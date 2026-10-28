<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>

<a class="goyostats-link-arrow goyostats-link-arrow--external" target="_blank" href="<?php echo esc_url($url); ?>" aria-label="<?php echo esc_html($title) ?>">
    <span><?php echo esc_html($title) ?></span>
    <?php if (!empty($tooltip)): ?>
        <span class="goyostats-tooltip" title="<?php echo esc_attr($tooltip) ?>"><i class="goyostats-tooltip-icon info"></i></span>
    <?php endif; ?>
</a>
