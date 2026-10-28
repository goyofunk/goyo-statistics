<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Utils\Request;
use Goyo_Statistics\Components\View;

View::load('components/objects/share-anonymous-notice');

if (isset($backUrl, $backTitle, $_SERVER['HTTP_REFERER'])) {
    if (empty($forceBackUrl)) { // if back url is not forced, get it from server
        $backUrl = esc_url_raw($_SERVER['HTTP_REFERER']);
    }

    $backTitle = esc_html__('Back to Previous Page', 'goyo-statistics');
}
?>
<div class="goyostats-wrap__top <?php echo false /* Premium realtime control removed. */ ? 'goyostats-wrap__top--has__realtime' : ''; ?>">
    <?php if (isset($backUrl, $backTitle)): ?>
        <a href="<?php echo esc_url($backUrl) ?>"  aria-label="<?php echo esc_html($backTitle) ?>" class="goyostats-previous-url"><?php echo esc_html($backTitle) ?></a>
    <?php endif ?>

    <?php if (isset($title)): ?>
        <h2 class="goyostats_title <?php echo isset($install_addon_btn_txt) ? 'goyostats_plugins_page-title' : '' ?>">
            <?php if (isset($flagImage)): ?>
                <img class="goyostats-flag" src="<?php echo esc_url($flagImage) ?>" alt="<?php echo esc_attr($title) ?>">
            <?php endif ?>
            <?php echo(isset($title) ? esc_attr($title) : (function_exists('get_admin_page_title') ? get_admin_page_title() : '')); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped	 ?>
            <?php if (!empty($tooltip)) : ?>
                <span class="goyostats-tooltip" title="<?php echo esc_attr($tooltip); ?>"><i class="goyostats-tooltip-icon info"></i></span>
            <?php endif; ?>

            <?php if (isset($install_addon_btn_txt)) : ?>
                <a href="<?php echo esc_attr($install_addon_btn_link); ?>" class="goyostats-install-addon-btn">
                    <span><?php echo esc_attr($install_addon_btn_txt); ?></span>
                </a>
            <?php endif; ?>
        </h2>
    <?php endif ?>
    <?php
    if (Menus::in_page('content-analytics') && Request::compare('type', 'single')) {
        View::load("components/headers/post-type");
    }
    if (Menus::in_page('content-analytics') && Request::compare('type', 'single-resource')) {
        View::load("components/headers/single-resource");
    }
    if (Menus::in_page('category-analytics') && Request::compare('type', 'single')) {
        View::load("components/headers/category-analytics");
    }
    if (Menus::in_page('author-analytics') && Request::compare('type', 'single-author')) {
        View::load("components/headers/author-analytics");
    }
    if ((Menus::in_page('download_tracker') || Menus::in_page('link_tracker')) && Request::compare('type', 'single')) {
        View::load("components/headers/tracker");
    }
    ?>

    <?php do_action('goyo_statistics_after_admin_page_title'); ?>



    <?php if (isset($hasDateRang) || isset($filters) || isset($searchBoxTitle) || isset($filter) || isset($export)): ?>
        <div class="<?php echo (Menus::in_page('content-analytics') || Menus::in_page('category-analytics') || Menus::in_page('author-analytics') || Menus::in_page('download_tracker') || Menus::in_page('link_tracker')) && (Request::compare('type', 'single') || Request::compare('type', 'single-author')) ? 'goyostats-head-filters goyostats-head-filters--custom' : 'goyostats-head-filters' ?>">

            <?php
                if (!empty($export) && is_array($export)) {
                    View::load("components/objects/export-button", ['types' => $export]);
                }
            ?>

            <?php if (isset($Datepicker)): ?>
                <form class="goyostats-search-date goyostats-today-datepicker" method="get">
                    <div>
                        <input type="hidden" name="page" value="<?php echo esc_attr($pageName); ?>">
                        <input class="goyostats-search-date__input goyostats-js-calendar-field" id="search-date-input" type="text" size="18" name="day" data-goyostats-date-picker="day" readonly value="<?php echo esc_attr($day); ?>" autocomplete="off" placeholder="YYYY-MM-DD" required>
                    </div>
                </form>
            <?php endif ?>
            <?php
            if (!empty($hasDateRang)) {
                include 'date.range.php';
            }

            if (isset($filter) and isset($filter['code'])) {
                echo $filter['code']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                ?>
                <div class="wp-clearfix"></div>
                <?php
            }

            if (!empty($filters)) {
                foreach ($filters as $filter) {
                    require_once "filters/$filter-filter.php";
                }
            }

            if (isset($searchBoxTitle)): ?>
                <div class="goyostats-filter-visitor goyostats-head-filters__item loading">
                    <div class="goyostats-dropdown">
                        <label for="goyostats-visitor-filter" class="selectedItemLabel"><?php echo esc_attr($searchBoxTitle); ?></label>
                        <select id="goyostats-visitor-filter" class="goyostats-select2" data-type-show="select2"></select>
                    </div>
                </div>
            <?php endif ?>
        </div>
    <?php endif ?>
</div>
<div class="goyostats-wrap__main">
    <div class="wp-header-end"></div>