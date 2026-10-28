<?php

use GOYO_STATISTICS\Helper;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

$id = 'goyostats-filter-' . $type;
?>

<div id="<?php echo esc_attr($id); ?>" class="goyostats-filter-post-type goyostats-head-filters__item">
    <div class="goyostats-dropdown">
        <span class="selectedItemLabel"><?php echo esc_html($title) ?>: </span>
        <button type="button" class="dropbtn"><span><?php echo ! empty($selectedOption) ? esc_html(Helper::getPostTypeName($selectedOption)) : esc_html__('All', 'goyo-statistics'); ?></span></button>
    </div>
</div>