<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;

?>
<div class="goyostats-card">
    <div class="goyostats-card__title">
        <h2>
            <?php echo esc_html($title); ?>
        </h2>
    </div>
    <div class="o-wrap goyostats-p-0">
        <div class="goyostats-postbox-chart">
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
                <canvas id="referredVisitorsChart">
            </div>
        </div>
    </div>
</div>
