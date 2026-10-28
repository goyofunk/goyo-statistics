<?php

namespace Goyo_Statistics\Service\Admin\AuthorAnalytics\Views;

use Goyo_Statistics\Abstracts\BaseView;
use GOYO_STATISTICS\Admin_Template;
use Goyo_Statistics\Components\View;
use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Service\Admin\AuthorAnalytics\AuthorAnalyticsDataProvider;
use Goyo_Statistics\Service\Admin\ExportImport\ExportTypes;
use Goyo_Statistics\Utils\Request;

class AuthorsView extends BaseView
{
    /**
     * Get author report data
     *
     * @return array
     */
    public function getData()
    {
        $postType = Request::get('pt', 'post');
        $orderBy  = Request::get('order_by');
        $order    = Request::get('order', 'DESC');

        $args = [
            'post_type' => $postType,
            'per_page'  => Admin_Template::$item_per_page,
            'page'      => Admin_Template::getCurrentPaged()
        ];

        if ($orderBy) {
            $args['order_by'] = $orderBy;
            $args['order']    = $order;
        }

        $authorAnalyticsData = new AuthorAnalyticsDataProvider($args);
        return $authorAnalyticsData->getAuthorsReportData();
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

    public function renderContent()
    {
        $data = $this->getData();

        $args = [
            'title'       => esc_html__('Authors', 'goyo-statistics'),
            'pageName'    => Menus::get_page_slug('author-analytics'),
            'DateRang'    => Admin_Template::DateRange(),
            'custom_get'  => [
                'type'      => 'authors',
                'pt'        => Request::get('pt', 'post'),
                'order_by'  => Request::get('order_by', 'total_views'),
                'order'     => Request::get('order', 'desc'),
            ],
            'hasDateRang' => true,
            'filters'     => ['post-type'],
            'backUrl'     => Menus::admin_url('author-analytics'),
            'backTitle'   => esc_html__('Authors Performance', 'goyo-statistics'),
            'export'      => [ExportTypes::CSV_TABLE, ExportTypes::PDF_PAGE],
            'data'        => $data['authors'],
            'paged'       => Admin_Template::getCurrentPaged(),
        ];

        if ($data['total'] > 0) {
            $args['total'] = $data['total'];

            $args['pagination'] = Admin_Template::paginate_links([
                'total' => $data['total'],
                'echo'  => false
            ]);
        }

        Admin_Template::get_template(['layout/header', 'layout/title', "pages/author-analytics/authors-report", 'layout/postbox.toggle', 'layout/footer'], $args);
    }

    public function render()
    {
        if ($this->isLocked()) {
            $this->renderLocked();
        } else {
            $this->renderContent();
        }
    }

    public function isLocked()
    {
        $postType = Request::get('pt', 'post');
        return !Helper::isAddOnActive('data-plus') && Helper::isCustomPostType($postType);
    }
}