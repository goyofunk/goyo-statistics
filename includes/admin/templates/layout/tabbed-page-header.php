<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Option;
use GOYO_STATISTICS\Menus;
use GOYO_STATISTICS\Helper;
use Goyo_Statistics\Utils\Url;
use Goyo_Statistics\Components\View;
use Goyo_Statistics\Globals\Context;
use Goyo_Statistics\Marketing\Services\Auth\AuthHelper;

$currentPage = Context::get('goyostats_page');

$pageKey    = $currentPage['slug'];
$currentTab = $currentPage['tab'] ?? '';
$currentTab = Helper::findInArray($tabs, 'id', $currentTab);

View::load('components/objects/share-anonymous-notice');
?>
<div class="goyostats-wrap__top tabbed_page">
    <h1 class="goyostats_title <?php if (!empty($create_goal_url)) echo 'goyostats_flex' ?>">
        <span><?php echo(isset($title) ? esc_html($title) : (function_exists('get_admin_page_title') ? esc_html(get_admin_page_title()) : '')); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
        <?php if (!empty($tooltip)) : ?>
            <span class="goyostats-tooltip" title="<?php echo esc_attr($tooltip); ?>"><i class="goyostats-tooltip-icon info"></i></span>
        <?php endif; ?>
        <?php if (!empty($create_goal_url)) : ?>
            <a href="<?php echo esc_url($create_goal_url) ?>" class="goyostats-button goyostats-button--outline-primary"> <?php esc_html_e('Add New Goal', 'goyo-statistics'); ?></a>
        <?php endif; ?>
    </h1>

    <?php if (!empty($description)) echo '<p class="goyostats_description">' . esc_html($description) . '</p>'    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped	?>

    <?php do_action('goyo_statistics_after_admin_page_title'); ?>


    <div class="wp-clearfix"></div>

    <?php
    $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : '';
    if (isset($datepicker)): ?>
        <form class="goyostats-search-date goyostats-today-datepicker" method="get">
            <div>
                <input type="hidden" name="page" value="<?php echo esc_attr($pageName); ?>">
                <input type="hidden" name="tab" id="active-tab-input" value="<?php echo esc_attr($active_tab); ?>">
                <input aria-label="day" class="goyostats-search-date__input goyostats-js-calendar-field" id="search-date-input" type="text" size="18" name="day" data-goyostats-date-picker="day" readonly value="<?php echo esc_attr($day); ?>" autocomplete="off" placeholder="YYYY-MM-DD" required>
            </div>
        </form>
    <?php endif ?>
    <?php if (isset($hasDateRang) || isset($filters) || isset($lastUpdated) || isset($currentTab['export'])) : ?>
        <div class="goyostats-head-filters">

            <?php
            if (!empty($currentTab['export']) && is_array($currentTab['export'])) {
                View::load("components/objects/export-button", ['types' => $currentTab['export']]);
            }



            if (!empty($hasDateRang)) {
                include 'date.range.php';
            }

            if (!empty($filters)) {
                foreach ($filters as $filter) {
                    require_once "filters/$filter-filter.php";
                }
            }

            if (!empty($tabs) && is_array($tabs)) {
                foreach ($tabs as $tab) {
                    if ($tab['class'] === 'current' || Url::getParam($tab['link'], 'tab') === $active_tab) {
                        if (!empty($tab['lastUpdated']) && !empty($tab['lastUpdatedTooltip']) && AuthHelper::isAuthenticated() && Option::getByAddon('site', 'marketing')) {
                            ?>
                            <div class="goyostats-last-updated goyostats-tooltip" title="<?php echo esc_attr($tab['lastUpdatedTooltip']); ?>">
                                <span>
                                     <?php esc_html_e('Last Updated:', 'goyo-statistics'); ?>
                                </span>
                                <span class="goyostats-loading"></span>
                            </div>
                            <?php
                        }
                        break;
                    }
                }
            }

            ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($tabs) && is_array($tabs)) { ?>
        <ul class="goyostats-tabs">
            <?php foreach ($tabs as $tab) {
                $tabKey         = Url::getParam($tab['link'], 'tab');
                $tab['locked']  = apply_filters("goyo_statistics_{$pageKey}_{$tabKey}_locked", $tab['locked'] ?? false);
                $tab['tooltip'] = apply_filters("goyo_statistics_{$pageKey}_{$tabKey}_tooltip", $tab['tooltip'] ?? '');
                $tab['hidden']  = apply_filters("goyo_statistics_{$pageKey}_{$tabKey}_hidden", $tab['hidden'] ?? false);

                if (!empty($tab['hidden']) || !empty($tab['locked']) || !empty($tab['coming_soon'])) continue;
                ?>

                <li class="goyostats-tab-link <?php echo esc_attr($tab['class']); ?>">
                    <?php if (isset($tab['coming_soon'])): ?>
                        <span class="goyostats-tooltip goyostats-tooltip--coming_soon" title="<?php echo esc_html__('Coming soon', 'goyo-statistics') ?>"><?php echo esc_html($tab['title']); ?> <i class="goyostats-tooltip-icon coming-soon"></i></span>
                    <?php elseif (!empty($tab['locked'])) : ?>
                        <a data-target="<?php echo isset($tab['lockedTarget']) ? esc_attr($tab['lockedTarget']) : "goyo-statistics-data-plus" ?>" class="js-goyostats-openPremiumModal goyostats-locked">
                            <?php echo esc_html($tab['title']); ?>
                            <?php if (!empty($tab['tooltip'])) : ?>
                                <span class="goyostats-tooltip" title="<?php echo esc_attr($tab['tooltip']) ?>"><i class="goyostats-tooltip-icon info"></i></span>
                            <?php endif; ?>
                        </a>
                    <?php elseif (isset($tab['pin'])) : ?>
                        <a href="<?php echo esc_attr($tab['link']); ?>" class="goyostats-tab-link--pin">
                            <?php echo esc_html($tab['title']); ?>
                            <i class="goyostats-tooltip-icon goyostats-pin"></i>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo esc_attr($tab['link']); ?>">
                            <?php echo esc_html($tab['title']); ?>
                            <?php if (!empty($tab['tooltip'])) : ?>
                                <span class="goyostats-tooltip" title="<?php echo esc_attr($tab['tooltip']); ?>"><i class="goyostats-tooltip-icon info"></i></span>
                            <?php endif; ?>

                            <?php if (strpos($tab['class'], 'goyostats-tab-link__online-visitors') !== false) : ?>
                                <span class="goyostats-dot goyostats-tooltip" title="<?php esc_html_e('Unique visitors who viewed a page in the last 5 minutes', 'goyo-statistics'); ?>">
                                   <span class="screen-reader-text"><?php esc_html_e('Unique visitors who viewed a page in the last 5 minutes', 'goyo-statistics'); ?></span>
                                </span>
                            <?php endif; ?>

                        </a>
                    <?php endif; ?>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</div>
<div class="goyostats-wrap__main">
    <div class="wp-header-end"></div>