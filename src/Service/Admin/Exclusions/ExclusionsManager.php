<?php
namespace Goyo_Statistics\Service\Admin\Exclusions;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Option;

class ExclusionsManager
{
    public function __construct()
    {
        if (Option::get('record_exclusions')) {
            add_filter('goyo_statistics_admin_menu_list', [$this, 'addMenuItem']);
        }
    }

    /**
     * Add menu item
     *
     * @param array $items
     * @return array
     */
    public function addMenuItem($items)
    {
        $items['exclusions'] = [
            'sub'      => 'overview',
            'title'    => esc_html__('Exclusions', 'goyo-statistics'),
            'page_url' => 'exclusions',
            'callback' => ExclusionsPage::class,
            'priority' => 999
        ];

        return $items;
    }
}