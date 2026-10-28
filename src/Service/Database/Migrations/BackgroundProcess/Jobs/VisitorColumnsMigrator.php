<?php

namespace Goyo_Statistics\Service\Database\Migrations\BackgroundProcess\Jobs;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Abstracts\BaseBackgroundProcess;
use GOYO_STATISTICS\Option;
use Goyo_Statistics\Service\Admin\NoticeHandler\Notice;
use Goyo_Statistics\Service\Database\DatabaseFactory;

class VisitorColumnsMigrator extends BaseBackgroundProcess
{
    /**
     * Background-process action slug for this job.
     *
     * @var string
     */
    protected $action = 'visitor_columns_migrator';

    /**
     * Initiated key for option storage.
     *
     * @var string
     */
    protected $initiatedKey = 'visitor_columns_migrator_initiated';

    /**
     * Number of visitor rows to include per batch window.
     * @var int
     */
    protected $batchSize = 100;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        add_action('admin_init', [$this, 'localizeJobTexts']);
    }

    /**
     * Localize the job's title and description for display in the admin UI.
     *
     * @return void
     */
    public function localizeJobTexts()
    {
        $this->setSuccessNotice(esc_html__('The visitor data migration was processed successfully.', 'goyo-statistics'));
        $this->setJobTitle(esc_html__('Migrate Visitor Data Columns', 'goyo-statistics'));
        $this->setJobDescription(esc_html__('Adjusts and updates visitor-related database columns to the latest WP Statistics format. Run this migration after upgrading from older versions to ensure your visitor data remains accurate and compatible.', 'goyo-statistics'));
    }

    /**
     * Perform task with queued item.
     *
     * Override this method to perform any actions required on each
     * queue item. Return the modified item for further processing
     * in the next pass through. Or, return false to remove the
     * item from the queue.
     *
     * @param mixed $item Queue item to iterate over.
     *
     * @return mixed
     */
    protected function task($item)
    {
        if (!is_array($item)) {
            return false;
        }

        $offset = isset($item['offset']) ? (int)$item['offset'] : 0;
        $limit  = isset($item['limit']) ? (int)$item['limit'] : $this->batchSize;

        $processedIds = [];

        $visitors = DatabaseFactory::table('select')
            ->setName('visitor_relationships AS vr')
            ->setArgs([
                'columns'  => ['vr.visitor_id', 'MIN(vr.ID) as min_id', 'MAX(vr.ID) as max_id'],
                'group_by' => 'vr.visitor_id',
                'joins'    => [
                    [
                        'table' => 'visitor',
                        'alias' => 'v',
                        'on'    => 'vr.visitor_id = v.ID',
                        'type'  => 'INNER'
                    ]
                ],
                'order_by' => 'vr.visitor_id ASC',
                'limit'    => [
                    $limit,
                    $offset,
                ]
            ])
            ->execute()
            ->getResult();

        if (empty($visitors)) {
            return false;
        }

        foreach ($visitors as $row) {
            $visitorId = $row['visitor_id'];
            $minId     = $row['min_id'];
            $maxId     = $row['max_id'];

            $firstPage = DatabaseFactory::table('select')
                ->setName('visitor_relationships')
                ->setArgs([
                    'columns' => ['page_id', 'date'],
                    'where'   => ['ID' => $minId],
                ])
                ->execute()
                ->getResult();

            $lastPage = DatabaseFactory::table('select')
                ->setName('visitor_relationships')
                ->setArgs([
                    'columns' => ['page_id', 'date'],
                    'where'   => ['ID' => $maxId],
                ])
                ->execute()
                ->getResult();

            if (!empty($firstPage) && !empty($lastPage)) {
                DatabaseFactory::table('insert')
                    ->setName('visitor')
                    ->setArgs([
                        'conditions' => [
                            'ID' => $visitorId,
                        ],
                        'mapping'    => [
                            'first_page' => $firstPage[0]['page_id'],
                            'first_view' => $firstPage[0]['date'],
                            'last_page'  => $lastPage[0]['page_id'],
                            'last_view'  => $lastPage[0]['date'],
                        ],
                    ])
                    ->execute();

                $processedIds[] = $visitorId;
            }
        }

        if (!empty($processedIds)) {
            $this->setProcessed($processedIds);
        }

        return false;
    }

    /**
     * Complete processing.
     *
     * Override if applicable, but ensure that the below actions are
     * performed, or, call parent::complete().
     */
    protected function complete()
    {
        parent::complete();

        $this->clearTotalAndProcessed();
    }

    /**
     * Show initial notice to start the background process.
     *
     * When `$force` is true, the generated action URL includes `force=1` so the
     * manager can re-initiate the job even if it has already been started.
     *
     * @param bool $force Whether to include the `force` flag to restart the job. Default false.
     * @return void
     */
    public function initialNotice($force = false)
    {
        if ($this->isInitiated() || $this->is_active()) {
            return;
        }

        $ajaxMigrationOption = Option::getOptionGroup('ajax_background_process', 'jobs', []);
        $ajaxIsDone          = Option::getOptionGroup('ajax_background_process', 'is_done', false);

        if ($ajaxIsDone || in_array('visitor_columns_migrate', $ajaxMigrationOption, true)) {
            Option::saveOptionGroup($this->getInitiatedKey(), true, 'jobs');
            return;
        }

        $actionUrl = $this->getActionUrl($force);

        $message = sprintf(
            '<div id="goyo-statistics-background-process-notice">
                <p><strong>%1$s</strong></p>
                <p>%2$s <br> %3$s</p>
                <p><a href="%4$s" id="start-migration-btn" class="button-primary">%5$s</a><a href="%6$s" style="margin: 10px" target="_blank">%7$s</a></p>
            </div>',
            esc_html__('WP Statistics: Migration Required', 'goyo-statistics'),
            __('A data migration is needed for WP Statistics. Click <strong>Start Migration</strong> below to begin.', 'goyo-statistics'),
            __('<strong>Note:</strong> If you leave this page before the migration finishes, the process will pause. You can always return later to resume.', 'goyo-statistics'),
            esc_url($actionUrl),
            esc_html__('Start Migration', 'goyo-statistics'),
            'https://wp-statistics.com/resources/database-migration-process-guide/?utm_source=goyo-statistics&utm_medium=link&utm_campaign=doc',
            esc_html__('Read More', 'goyo-statistics')
        );

        Notice::addNotice($message, 'start_visitor_background_process', 'warning', false);
    }

    /**
     * Initiate the background process to calculate word counts for posts.
     *
     * @return void
     */
    public function process()
    {
        if ($this->is_active() || $this->isInitiated()) {
            return;
        }

        $this->clearTotalAndProcessed();

        $result = DatabaseFactory::table('select')
            ->setName('visitor_relationships AS vr')
            ->setArgs([
                'columns' => ['COUNT(DISTINCT vr.visitor_id) as total'],
                'joins'   => [
                    [
                        'table' => 'visitor',
                        'alias' => 'v',
                        'on'    => 'vr.visitor_id = v.ID',
                        'type'  => 'INNER'
                    ]
                ],
            ])
            ->execute()
            ->getResult();

        $totalCount = !empty($result[0]['total']) ? $result[0]['total'] : 0;

        $this->setTotal($totalCount);

        $flushEvery = 500;
        $queued     = 0;

        for ($offset = 0; $offset < $totalCount; $offset += $this->batchSize) {
            $this->push_to_queue([
                'offset' => $offset,
                'limit'  => $this->batchSize,
            ]);

            if ((++$queued % $flushEvery) === 0) {
                $this->save();
            }
        }

        $this->setInitiated();
        $this->save()->dispatch();
    }
}
