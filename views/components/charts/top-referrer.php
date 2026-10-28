<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;
?>
<div class="goyostats-card">
    <div class="goyostats-card__title">
        <h2>
            <?php echo esc_html($title); ?>
            <?php if (!empty($tooltip)): ?>
                <span class="goyostats-tooltip" title="<?php echo esc_attr($tooltip); ?>"><i class="goyostats-tooltip-icon info"></i></span>
            <?php endif ?>
        </h2>
    </div>
    <div class="o-wrap goyostats-p-0">
        <div class="goyostats-postbox-chart goyostats-p-0">
            <div class="goyostats-postbox-chart--data c-chart__wps-skeleton--legend">
                <div class="goyostats-postbox-chart--items"></div>
                <div class="goyostats-postbox-chart--info">
                    <div class="goyostats-postbox-chart--previousPeriod">
                        <?php esc_html_e('Previous period', 'goyo-statistics') ?>
                    </div>
                    <?php View::load("components/objects/chart-time-range"); ?>
                </div>
            </div>
            <div class="goyostats-postbox-chart--container c-chart__wps-skeleton">
                <canvas id="<?php echo esc_html($unique_id); ?>" aria-label="<?php echo esc_html($title); ?> chart" role="img">
            </div>
        </div>
    </div>
    <?php if(isset($footer_title)):?>
        <div class="goyostats-card__footer">
            <div class="goyostats-card__footer__more">
                <a class="goyostats-card__footer__more__link" href="<?php echo esc_url($footer_link) ?>">
                    <?php echo esc_html($footer_title); ?>
                </a>
            </div>
        </div>
    <?php endif;?>
</div>
