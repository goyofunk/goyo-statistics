<?php

namespace Goyo_Statistics\Service\Admin\AuthorAnalytics\Views;

use Exception;
use Goyo_Statistics\Abstracts\BaseView;
use GOYO_STATISTICS\Admin_Template;
use Goyo_Statistics\Components\View;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Service\Admin\ExportImport\ExportTypes;

class SingleAuthorView extends BaseView
{
    public function render()
    {
        $args = [
            'page_title'        => esc_html__('Uncover Author Performance at a Glance', 'goyo-statistics'),
            'addon_name'        => esc_html__('Data Plus', 'goyo-statistics'),
            'addon_slug'        => 'goyo-statistics-data-plus',
            'campaign'          => 'data-plus',
            'more_title'        => esc_html__('Learn More', 'goyo-statistics'),
            'premium_btn_title' => esc_html__('Discover Author Insights with Premium', 'goyo-statistics'),
            'images'            => ['data-plus-single-author.png'],
            'export'            => [ExportTypes::CSV_METRICS, ExportTypes::PDF_PAGE],
            'description'       => esc_html__('Track your authors\' impact, top posts, and engagement trends in one place. With Author Analytics, you get the insights needed to boost your content strategy.', 'goyo-statistics'),
        ];

        Admin_Template::get_template(['layout/header']);
        View::load("pages/lock-page", $args);
        Admin_Template::get_template(['layout/footer']);
    }
}