<?php

namespace Goyo_Statistics\Abstracts;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Exception;
use Goyo_Statistics\Components\DateTime;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Components\Singleton;
use Goyo_Statistics\Service\Admin\NoticeHandler\Notice;
use Goyo_Statistics\Utils\Request;

abstract class BasePage extends Singleton
{
    protected $pageSlug;

    public function __construct()
    {
        if (Menus::in_page($this->pageSlug)) {
            $this->init();
        }
    }

    protected function init()
    {
    }

    protected function disableScreenOption()
    {
        add_filter('screen_options_show_screen', '__return_false');
    }

    public function getPageSlug()
    {
        return $this->pageSlug;
    }

    public function render()
    {
    }

    /**
     * Validates the given date range.
     *
     * @throws Exception
     */
    public function validateDateRange()
    {
        $from = Request::get('from');
        $to   = Request::get('to');

        // If date range is empty no validation is needed
        if (empty($from) && empty($to)) return;

        // Check if `from` or `to` is empty, throw error
        if (empty($from) || empty($to)) {
            throw new Exception(esc_html__('Invalid date: provided date range is not valid.', 'goyo-statistics'));
        }

        // Check if `from` and `to` are not valid dates, throw error
        if (!DateTime::isValidDate($from) || !DateTime::isValidDate($to)) {
            throw new Exception(esc_html__('Invalid date: provided date range is not in the right format.', 'goyo-statistics'));
        }

        // If starting date is greater than ending date, throw error
        if (strtotime($from) > strtotime($to)) {
            throw new Exception(esc_html__('Invalid date: starting date is greater than ending date.', 'goyo-statistics'));
        }
    }

    public function view()
    {
        try {
            $this->validateDateRange();
            $this->render();
        } catch (Exception $e) {
            Notice::renderNotice($e->getMessage(), $e->getCode(), 'error');
        }
    }
}