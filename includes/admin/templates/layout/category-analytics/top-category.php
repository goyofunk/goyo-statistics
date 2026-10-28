<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Utils\Request;
use Goyo_Statistics\Components\View;

$taxonomy  = Request::get('tx', 'category');
?>

<div class="goyostats-card">
    <div class="goyostats-card__title">
        <h2>
            <?php echo esc_html($title) ?>
            <?php if ($tooltip): ?>
                <span class="goyostats-tooltip" title="<?php echo esc_attr($tooltip); ?>"><i class="goyostats-tooltip-icon info"></i></span>
            <?php endif ?>
        </h2>
    </div>
    <div class="goyostats-flex-container">
        <div class="goyostats-flex-half">
            <div class="goyostats-tabs">
                <input type="radio" name="category-views" id="top-category-views" checked="checked">
                <label for="top-category-views"><?php esc_html_e('Views', 'goyo-statistics') ?></label>
                <div class="goyostats-tabs__content">
                    <?php
                    if (!empty($data['viewing'])) {
                        $counter = 1;
                        foreach ($data['viewing'] as $term) : ?>
                            <a class="goyostats-tabs-item" href="<?php echo esc_url(Menus::admin_url('category-analytics', ['type' => 'single', 'term_id' => $term->term_id])) ?>">
                                <div class="goyostats-content-tabs__item--content">
                                    <h3 class="goyostats-ellipsis-parent"><span class="goyostats-ellipsis-text"><?php echo esc_html($term->term_name); ?></span></h3>
                                    <span>
                                        <span class="goyostats-content-tabs__item--count"><?php echo esc_html(Helper::formatNumberWithUnit($term->views));?></span><?php esc_html_e('content views', 'goyo-statistics') ?>
                                    </span>
                                </div>
                            </a>
                            <?php $counter++;
                        endforeach;
                    } else {
                        ?>
                        <div class="o-wrap o-wrap--no-data"><p><?php esc_html_e('No recent data available.', 'goyo-statistics') ?></p></div><?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="goyostats-flex-half">
            <div class="goyostats-tabs">
                <input type="radio" name="category-publishing" id="top-category-publishing" checked="checked">
                <label for="top-category-publishing"><?php esc_html_e('Publishing', 'goyo-statistics') ?></label>
                <div class="goyostats-tabs__content">
                    <?php
                    if (!empty($data['publishing'])) {
                        $counter = 1;
                        foreach ($data['publishing'] as $term) : ?>
                            <a class="goyostats-tabs-item" href="<?php echo esc_url(Menus::admin_url('category-analytics', ['type' => 'single', 'term_id' => $term->term_id])) ?>">
                                <div class="goyostats-content-tabs__item--content">
                                    <h3 class="goyostats-ellipsis-parent"><span class="goyostats-ellipsis-text"><?php echo esc_html($term->term_name); ?></span></h3>
                                    <span>
                                        <span class="goyostats-content-tabs__item--count"><?php echo esc_html(number_format_i18n($term->posts)); ?></span><?php esc_html_e('contents published', 'goyo-statistics') ?>
                                    </span>
                                </div>
                            </a>
                            <?php $counter++;
                        endforeach;
                    } else {
                        ?>
                        <div class="o-wrap o-wrap--no-data"><p><?php esc_html_e('No recent data available.', 'goyo-statistics') ?></p></div><?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    View::load("components/objects/view-more", [
        'href'  => Menus::admin_url('category-analytics', ['type' => 'report', 'tx' => $taxonomy]),
        'title' => __('See all categories', 'goyo-statistics'),
    ]);
    ?>
</div>