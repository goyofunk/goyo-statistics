<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;

?>

<div class="goyostats-card">
    <div class="goyostats-card__title">
        <h2>
            <?php echo esc_html($title); ?>
            <?php if ($tooltip): ?>
                <span class="goyostats-tooltip" title="<?php echo esc_attr($tooltip); ?>"><i class="goyostats-tooltip-icon info"></i></span>
            <?php endif ?>
        </h2>
    </div>
    <div class="o-wrap goyostats-p-0">
        <div class="goyostats-postbox-chart--data">
            <div class="goyostats-postbox-chart--items"></div>
            <div class="goyostats-postbox-chart--info">
                <div class="goyostats-postbox-chart--previousPeriod">
                    <?php esc_html_e('Previous period', 'goyo-statistics'); ?>
                </div>
                <?php View::load("components/objects/chart-time-range"); ?>
            </div>
        </div>
        <div class="goyostats-postbox-chart--container">
            <canvas id="<?php echo esc_attr($unique_id); ?>" aria-label="<?php echo esc_html__('Search engines chart', 'goyo-statistics') ?>" role="img"></canvas>
        </div>
    </div>
</div>