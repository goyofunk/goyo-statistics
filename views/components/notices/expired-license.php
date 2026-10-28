<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-notice goyostats-notice--danger">
    <div>
        <p class="goyostats-notice__title"><?php esc_html_e('Expired or Invalid License', 'goyo-statistics'); ?></p>
        <div class="goyostats-notice__description">
            <?php
            echo wp_kses_post(sprintf(
                /* translators: %1$s: string value, %2$s: string value, %3$s: string value */
                __('Your WP Statistics license %1$s has expired or isn’t valid. Without a valid license, we can’t ensure security or compatibility updates. <br> <a href="%2$s" target="_blank">Renew</a> or update your license to keep everything running smoothly. <br> Need help? <a target="_blank" href="%3$s">Contact Support</a>', 'goyo-statistics'),
                implode(", ", array_map(function($license) {
                    return '<code>' . esc_html($license) . '</code>';
                }, $data['invalid_licenses'])),
                esc_url("https://wp-statistics.com/my-account/subscriptions/"),
                esc_url("https://wp-statistics.com/contact-us/?utm_source=goyo-statistics&utm_medium=link&utm_campaign=install-addon")
            ));
            ?>
        </div>
    </div>
</div>
