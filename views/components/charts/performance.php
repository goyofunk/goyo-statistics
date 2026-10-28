<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Utils\Request;
use Goyo_Statistics\Components\View;

$postType = Request::get('tab', 'post');
?>

<div class="goyostats-card">
    <div class="goyostats-card__title">
        <h2>
            <?php echo esc_html($title); ?>
            <?php if (isset($tooltip) && $tooltip): ?>
                <span class="goyostats-tooltip" title="<?php echo esc_attr($tooltip); ?>"><i class="goyostats-tooltip-icon info"></i></span>
            <?php endif ?>
        </h2>
    </div>
    <div class="o-wrap goyostats-p-0">
        <div class="goyostats-postbox-chart--data c-goyostats-performance-chart__items">
            <div class="goyostats-postbox-chart--items"></div>
            <div class="goyostats-postbox-chart--info">
                <div class="goyostats-postbox-chart--previousPeriod">
                    <?php esc_html_e('Previous period', 'goyo-statistics') ?>
                </div>
                <?php View::load("components/objects/chart-time-range"); ?>
            </div>
        </div>
        <div class="goyostats-postbox-chart--container c-goyostats-performance-chart__container">
            <?php
            $canvasIds = [
                'category'       => 'performance-category-chart',
                'categorySingle' => 'performance-category-chart-single',
                'post-type'      => 'performance-chart',
                'single'         => 'performance-chart-single',
            ];

            if (isset($canvasIds[$type])) {
                echo '<canvas id="' . esc_attr($canvasIds[$type]) . '" height="299" aria-label="' .esc_html__("Performance chart", "goyo-statistics"). '" role="img"></canvas>';
            }
            ?>
        </div>
    </div>
</div>