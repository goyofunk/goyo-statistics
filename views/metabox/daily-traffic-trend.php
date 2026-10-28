<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;

?>
<div class="o-wrap">
    <div class="goyostats-postbox-chart--data">
        <div class="goyostats-postbox-chart--items"></div>
        <div class="goyostats-postbox-chart--info">
            <div class="goyostats-postbox-chart--previousPeriod"><?php echo esc_html__('Previous period', 'goyo-statistics') ?></div>
            <?php View::load("components/objects/chart-time-range"); ?>
        </div>
    </div>
    <div class="goyostats-postbox-chart--container">
        <p class="screen-reader-text">
            <?php echo esc_html__('Day-by-day breakdown of views and page views chart over the selected period', 'goyo-statistics') ?>
        </p>
        <canvas id="goyo-statistics-hits-widget-chart" height="210" aria-label="<?php echo esc_html__('Traffic trend chart', 'goyo-statistics') ?>" role="img"></canvas>
    </div>
</div>