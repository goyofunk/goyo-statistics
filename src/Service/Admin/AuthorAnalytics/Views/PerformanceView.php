<?php

namespace Goyo_Statistics\Service\Admin\AuthorAnalytics\Views;

use Goyo_Statistics\Abstracts\BaseView;
use GOYO_STATISTICS\Admin_Assets;
use GOYO_STATISTICS\Admin_Template;
use Goyo_Statistics\Components\View;
use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Service\Admin\AuthorAnalytics\AuthorAnalyticsDataProvider;
use Goyo_Statistics\Service\Admin\ExportImport\ExportTypes;
use Goyo_Statistics\Utils\Request;

class PerformanceView extends BaseView
{
    public function __construct()
    {
        $args = [
            'post_type' => Request::get('pt', 'post')
        ];

        $this->dataProvider = new AuthorAnalyticsDataProvider($args);
    }

    public function getData()
    {
        wp_localize_script(Admin_Assets::$prefix, 'Goyo_Statistics_Author_Analytics_Object', $this->dataProvider->getAuthorsChartData());

        return $this->dataProvider->getAuthorsPerformanceData();
    }

    public function isLocked()
    {
        return !Helper::isAddOnActive('data-plus') && Helper::isCustomPostType(Request::get('pt', 'post'));
    }

    public function renderContent()
    {
        $args = [
            'title'       => esc_html__('Author Analytics', 'goyo-statistics'),
            'pageName'    => Menus::get_page_slug('author-analytics'),
            'paged'       => Admin_Template::getCurrentPaged(),
            'custom_get'  => ['pt' => Request::get('pt', 'post')],
            'export'      => [ExportTypes::CSV_METRICS, ExportTypes::PDF_PAGE],
            'DateRang'    => Admin_Template::DateRange(),
            'hasDateRang' => true,
            'filters'     => ['post-type'],
            'data'        => $this->getData()
        ];

        Admin_Template::get_template(['layout/header', 'layout/title', "pages/author-analytics/authors-performance", 'layout/postbox.hide', 'layout/footer'], $args);
    }

    public function renderLocked()
    {
        $args = [
            'page_title'        => esc_html__('Uncover Author Performance at a Glance', 'goyo-statistics'),
            'addon_name'        => esc_html__('Data Plus', 'goyo-statistics'),
            'addon_slug'        => 'goyo-statistics-data-plus',
            'campaign'          => 'data-plus',
            'more_title'        => esc_html__('Learn More', 'goyo-statistics'),
            'premium_btn_title' => esc_html__('Discover Author Insights with Premium', 'goyo-statistics'),
            'images'            => ['data-plus-single-author.png'],
            'description'       => esc_html__('Track your authors\' impact, top posts, and engagement trends in one place. With Author Analytics, you get the insights needed to boost your content strategy.', 'goyo-statistics'),
        ];
        Admin_Template::get_template(['layout/header']);
        View::load("pages/lock-page", $args);
        Admin_Template::get_template(['layout/footer']);
    }

    public function render()
    {
        if ($this->isLocked()) {
            $this->renderLocked();
        } else {
            $this->renderContent();
        }
    }
}