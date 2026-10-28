<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;

?>
<div class="o-wrap goyostats-p-0">
    <div class="goyostats-postbox-chart goyostats-postbox-chart--<?php echo esc_attr($chart_id) ?>">
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
            <canvas id="<?php echo esc_attr($chart_id) ?>" aria-label="<?php echo esc_html__('Traffic trend chart', 'goyo-statistics') ?>" role="img">
        </div>
    </div>
</div>