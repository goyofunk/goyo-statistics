<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

$is_rtl = is_rtl();
$text_align = $is_rtl ? 'right' : 'left';
$dir = $is_rtl ? 'rtl' : 'ltr';
?>
<div class="footer" style="font-family:  -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen-Sans, Ubuntu, Cantarell, Helvetica Neue,sans-serif; margin: 0; margin-top: 39px; padding: 0; text-align: center; text-decoration: none;">
    <span style="color: #56585A; font-family:  -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen-Sans, Ubuntu, Cantarell, Helvetica Neue,sans-serif; font-size: 14px; font-style: italic; font-weight: 500; line-height: 16.41px; margin: 0; padding: 0; text-decoration: none;">
        <?php esc_html_e('This email was auto-generated and sent from', 'goyo-statistics'); ?>
        <a href="<?php echo esc_url(get_site_url()) ?>" title="<?php  echo esc_attr(get_bloginfo('name')) ?>" style="color: #175DA4; font-family:  -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen-Sans, Ubuntu, Cantarell, Helvetica Neue,sans-serif; font-size: 14px; font-weight: 500; line-height: 16.41px; margin: 0; padding: 0"><?php  echo esc_html(get_bloginfo('name'));?></a>.
         <?php esc_html_e('Learn', 'goyo-statistics'); ?>
        <a href="https://wp-statistics.com/resources/how-to-manage-automated-report-delivery/?utm_source=goyo-statistics&utm_medium=email&utm_campaign=disable-report" title="<?php esc_html_e('how to disable it', 'goyo-statistics'); ?>" style="color: #175DA4; font-family:  -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen-Sans, Ubuntu, Cantarell, Helvetica Neue,sans-serif; font-size: 14px; font-weight: 500; line-height: 16.41px; margin: 0; padding: 0"><?php esc_html_e('how to disable it', 'goyo-statistics'); ?></a>.
    </span>
</div>