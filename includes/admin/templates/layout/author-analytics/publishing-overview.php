<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-card goyostats-wrap">
    <div class="goyostats-card__title">
        <h2>
            <?php echo esc_html($title); ?>
            <?php if ($tooltip) : ?>
                <span class="goyostats-tooltip" title="<?php echo esc_attr($tooltip); ?>"><i class="goyostats-tooltip-icon info"></i></span>
            <?php endif ?>
        </h2>
        <?php if ($description) : ?>
            <p><?php echo esc_html($description); ?></p>
        <?php endif ?>
    </div>
    <div class="goyostats-card__chart-matrix">
        <div class="chart-container">
            <canvas id="overviewPublishChart" aria-label="<?php echo esc_html__('Publishing overview chart', 'goyo-statistics') ?>" role="img">
        </div>
        <div class="goyostats-card__chart-guide">
            <div class="goyostats-card__chart-guide--items">
                <span><?php esc_html_e('Less', 'goyo-statistics') ?></span>
                <ul>
                    <li class="goyostats-card__chart-guide--item"></li>
                    <li class="goyostats-card__chart-guide--item"></li>
                    <li class="goyostats-card__chart-guide--item"></li>
                    <li class="goyostats-card__chart-guide--item"></li>
                    <li class="goyostats-card__chart-guide--item"></li>
                </ul>
                <span><?php esc_html_e('More', 'goyo-statistics') ?></span>
            </div>
        </div>
    </div>
</div>