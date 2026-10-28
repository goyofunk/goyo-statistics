<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-referral-link">
    <?php if (!empty($title)) : ?>
        <a class="goyostats-link-arrow goyostats-link-arrow--external" title="<?php echo esc_html($title)?>" target="_blank"  href="<?php echo esc_url($url); ?>">
            <span title="<?php echo esc_html($title)?>"><?php echo esc_html($title)?></span>
            <?php if (isset($badge)) : ?>
            <b class="badge"><?php echo esc_html($badge)?></b>
            <?php endif; ?>
        </a>
    <?php endif; ?>

    <span class="goyostats-referral-label"><?php echo esc_html($label)?></span>
</div>
