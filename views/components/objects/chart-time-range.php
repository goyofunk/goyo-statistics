<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-unit-time-chart">
    <div class="goyostats-custom-select js-goyo-unitTimeSelect">
        <span class="goyostats-unit-time-chart__selected-item"></span>
        <div class="goyostats-unit-time-chart__dropdown">
            <div class="goyostats-unit-time-chart__option" data-value="day"><?php echo esc_html__('Daily', 'goyo-statistics') ?></div>
            <div class="goyostats-unit-time-chart__option" data-value="week"><?php echo esc_html__('Weekly', 'goyo-statistics') ?></div>
            <div class="goyostats-unit-time-chart__option" data-value="month"><?php echo esc_html__('Monthly', 'goyo-statistics') ?></div>
        </div>
    </div>
</div>