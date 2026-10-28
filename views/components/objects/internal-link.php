<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<a class="goyostats-ellipsis-parent goyostats-internal-link" href="<?php echo esc_url($url); ?>" aria-label="<?php echo esc_html($title) ?>">
    <span class="goyostats-ellipsis-text"><?php echo esc_html($title) ?></span>
    <?php if (!empty($tooltip)): ?>
        <span class="goyostats-tooltip" title="<?php echo esc_attr($tooltip); ?>"><i class="goyostats-tooltip-icon info"></i></span>
    <?php endif; ?>
</a>