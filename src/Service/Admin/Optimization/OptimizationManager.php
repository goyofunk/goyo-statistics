<?php
namespace Goyo_Statistics\Service\Admin\Optimization;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Option;
use GOYO_STATISTICS\User;

class OptimizationManager
{
    public function __construct()
    {
        add_filter('goyo_statistics_admin_menu_list', [$this, 'addMenuItem']);
        add_action('admin_init', [$this, 'registerAjaxCallbacks']);
    }

    /**
     * Add menu item
     *
     * @param array $items
     * @return array
     */
    public function addMenuItem($items)
    {
        $items['optimize'] = [
            'sub'      => 'overview',
            'title'    => esc_html__('Optimization', 'goyo-statistics'),
            'cap'      => User::ExistCapability(Option::get('manage_capability', 'manage_options')),
            'page_url' => 'optimization',
            'method'   => 'optimization',
            'priority' => 110,
            'callback' => OptimizationPage::class
        ];

        return $items;
    }

    public function registerAjaxCallbacks()
    {
        $optimizationActions = new OptimizationActions();
        $optimizationActions->register();
    }
}