<?php
namespace Goyo_Statistics\Service\Admin\Metabox\Metaboxes;

use Goyo_Statistics\Components\View;
use Goyo_Statistics\Abstracts\BaseMetabox;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Components\DateTime;

class MostVisitedPages extends BaseMetabox
{
    protected $key = 'pages';
    protected $context = 'normal';

    public function getName()
    {
        return '인기페이지';
    }

    public function getDescription()
    {
        return esc_html__('Pages on your website with the highest number of views in the selected time frame.', 'goyo-statistics');
    }

    public function getOptions()
    {
        return [
            'datepicker' => true,
            'button'     => View::load('metabox/action-button', [
                'link'  => Menus::admin_url('pages', ['tab' => 'top']),
                'title' => esc_html__('View Top Pages', 'goyo-statistics')
            ], true)
        ];
    }

    public function getData()
    {
        $args = array_merge($this->getFilters(), ['per_page' => 20]);
        $data = $this->dataProvider->getTopPages($args);

        $isTodayOrFutureDate = DateTime::isTodayOrFutureDate($args['date']['to'] ?? null);

        $output = View::load('metabox/most-visited-pages', ['data' => $data, 'args' => $args, 'isTodayOrFutureDate' => $isTodayOrFutureDate], true);

        return $output;
    }

    public function render()
    {
        View::load('metabox/metabox-skeleton', []);
    }
}