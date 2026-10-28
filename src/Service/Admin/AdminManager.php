<?php

namespace Goyo_Statistics\Service\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Service\Admin\NoticeHandler\Notice;

class AdminManager
{
    public function __construct()
    {
        $this->initFooterModifier();
        $this->initNoticeHandler();
        $this->initSiteHealthInfo();
        $this->initAjaxOptionUpdater();
    }

    private function initFooterModifier()
    {
        add_filter('admin_footer_text', array($this, 'modifyAdminFooterText'), 999);
        add_filter('update_footer', array($this, 'modifyAdminUpdateFooter'), 999);
    }

    private function initNoticeHandler()
    {
        add_action('admin_notices', [Notice::class, 'displayNotices']);
        add_action('admin_init', [Notice::class, 'handleDismissNotice']);
        add_action('admin_init', [Notice::class, 'handleGeneralNotices'], 11);
    }

    private function initSiteHealthInfo()
    {
        // Initialize Site Health Info and register its hooks
        $siteHealthInfo = new SiteHealthInfo();
        $siteHealthInfo->register();
    }

    /**
     *
     */
    private function initAjaxOptionUpdater()
    {
        $optionUpdater = new AjaxOptionUpdater();
        $optionUpdater->init();
    }

    /**
     * Include footer
     */
    public function modifyAdminFooterText($text)
    {
        $screen = get_current_screen();

        if (apply_filters('goyo_statistics_enable_footer_text', true) && stripos($screen->id, 'goyostats_') !== false) {
            $text = sprintf(
                /* translators: %1$s: string value, %2$s: string value, %3$s: string value, %4$s: string value */
                __('Please rate <strong>WP Statistics</strong> <a href="%1$s" aria-label="%2$s" title="%3$s" target="_blank">★★★★★ %4$s</a> to help us spread the word. Thank you!', 'goyo-statistics'),
                'https://wordpress.org/plugins/goyo-statistics/#reviews',
                esc_attr__('Rate WP Statistics with five stars on WordPress.org', 'goyo-statistics'),
                esc_attr__('Rate WP Statistics', 'goyo-statistics'),
                esc_html__('on WordPress.org', 'goyo-statistics')
            );
        }
        return $text;
    }

    public function modifyAdminUpdateFooter($content)
    {
        $screen = get_current_screen();

        if (apply_filters('goyo_statistics_enable_footer_text', true) && stripos($screen->id, 'goyostats_') !== false) {
            global $wp_version;

            $content = sprintf('<p id="footer-upgrade" class="alignright">%s | %s %s</p>',
                esc_html__('WordPress', 'goyo-statistics') . ' ' . esc_html($wp_version),
                esc_html('WP Statistics'),
                esc_attr(GOYO_STATISTICS_VERSION)
            );
        }
        return $content;
    }
}