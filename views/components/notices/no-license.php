<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-notice goyostats-notice--success">
    <div>
        <p class="goyostats-notice__title"><?php esc_html_e('No WP Statistics License Detected', 'goyo-statistics') ?></p>
        <div class="goyostats-notice__description">
            <?php
            echo wp_kses_post(sprintf(
                /* translators: %1$s: string value, %2$s: string value */
                __('You haven’t registered a WP Statistics license yet. Having a valid license unlocks premium add-ons and features. <a href="%1$s" target="_blank">Purchase</a> or <a href="%2$s">add a license</a> now to get started!.', 'goyo-statistics'),
                esc_url('https://wp-statistics.com/pricing/?utm_source=goyo-statistics&utm_medium=link&utm_campaign=install-addon'),
                esc_url($data['install_addon_link'])
            ));
            ?>
        </div>
    </div>
</div>
