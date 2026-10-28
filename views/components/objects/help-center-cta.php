<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-help__cta">
    <div>
        <h2 class="goyostats-help__cta-title">
            <?php echo esc_html($title) ?>
        </h2>
        <p class="goyostats-help__cta-description">
            <?php echo esc_html($description); ?>
        </p>
    </div>
    <?php if (isset($cta_link)): ?>
        <a href="<?php echo esc_url($cta_link); ?>" target="_blank" class="button button-primary goyostats-help__cta-button">
            <?php echo esc_html($cta_title); ?>
        </a>
    <?php endif; ?>
</div>