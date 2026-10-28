<?php

namespace Goyo_Statistics\Service\Admin\LicenseManagement\Views;

use Goyo_Statistics\Components\View;
use GOYO_STATISTICS\Admin_Template;
use Goyo_Statistics\Abstracts\BaseView;

class LockedMiniChartView extends BaseView
{
    public function render()
    {
        $args = [
            'page_title'         => esc_html__('Mini Chart: Easy Insights, Right in Your Dashboard', 'goyo-statistics'),
            'page_second_title'  => esc_html__('WP Statistics Premium: Beyond Just Mini Chart', 'goyo-statistics'),
            'addon_name'         => esc_html__('Mini Chart', 'goyo-statistics'),
            'addon_slug'         => 'goyo-statistics-mini-chart',
            'campaign'           => 'mini-chart',
            'more_title'         => esc_html__('Learn More About Mini Chart', 'goyo-statistics'),
            'premium_btn_title'  => esc_html__('Upgrade Now to Unlock All Premium Features!', 'goyo-statistics'),
            'images'             => ['mini-chart-1.png', 'mini-chart-2.png', 'mini-chart-3.png'],
            'description'        => esc_html__('Mini Chart is a premium add-on for WP Statistics that gives you quick, clear insights into how your posts, pages, and products are doing. It shows small, customizable charts right in your admin area, so you can easily track views and engagement. You can change the chart types and colors to fit your style. With Mini Chart, it\'s simple to keep an eye on important numbers without spending a lot of time.', 'goyo-statistics'),
            'second_description' => esc_html__('When you upgrade to WP Statistics Premium, you don\'t just get Mini Chart — you unlock all premium add-ons, providing complete insights for your site. ', 'goyo-statistics')
        ];

        Admin_Template::get_template(['layout/header']);
        View::load("pages/lock-page", $args);
        Admin_Template::get_template(['layout/footer']);
    }
}
