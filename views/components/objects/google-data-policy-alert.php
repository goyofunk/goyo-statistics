<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-addon-settings-marketing--alert">
    <div>
        <h3><?php esc_html_e('Privacy & Data', 'goyo-statistics'); ?></h3>
        <p><?php echo wp_kses_post($content); ?></p>
    </div>
</div>