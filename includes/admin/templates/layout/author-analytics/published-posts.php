<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-card goyostats-wrap">
    <div class="goyostats-card__title">
        <h2>
            <?php echo esc_html($title); ?>
            <?php if ($tooltip): ?>
                <span class="goyostats-tooltip" title="<?php echo esc_attr($tooltip); ?>"><i class="goyostats-tooltip-icon info"></i></span>
            <?php endif ?>
        </h2>
    </div>
    <div class="goyostats-scatter-chart">
        <div class="chart-container">
            <canvas id="publishedChart" aria-label="<?php echo esc_html__('published chart', 'goyo-statistics') ?>" role="img"></canvas>
        </div>
    </div>
</div>