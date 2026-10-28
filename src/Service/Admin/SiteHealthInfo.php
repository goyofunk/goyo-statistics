<?php

namespace Goyo_Statistics\Service\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Option;

/**
 * Class SiteHealthInfo
 *
 * @package Goyo_Statistics\Service\Admin
 */
class SiteHealthInfo
{
    /**
     * Slug for the WP Statistics debug information section.
     */
    const DEBUG_INFO_SLUG = 'goyo_statistics';

    public function register()
    {
        add_filter('debug_information', [$this, 'addStatisticsInfo']);
    }

    /**
     * Add WP Statistics debug information to the Site Health Info page.
     *
     * @param array $info
     *
     * @return array
     */
    public function addStatisticsInfo($info)
    {
        $allSettings = array_merge(
            $this->getPluginSettings(),
            $this->getAddOnsSettings()
        );

        $info[self::DEBUG_INFO_SLUG] = [
            'label'       => esc_html__('WP Statistics', 'goyo-statistics'),
            'description' => esc_html__('This section contains debug information about your WP Statistics settings to help you troubleshoot issues.', 'goyo-statistics'),
            'fields'      => $allSettings,
        ];

        return $info;
    }

    /**
     * Get plugin settings.
     *
     * @return array
     */
    public function getPluginSettings()
    {
        $userRoleExclusions      = $this->getUserRoleExclusions(false);
        $consentIntegration = Option::get('consent_integration');

        $settings = [
            /**
             * General settings.
             */
            'version'                        => [
                'label' => esc_html__('Version', 'goyo-statistics'),
                'value' => GOYO_STATISTICS_VERSION,
            ],
            'database_version'               => [
                'label' => esc_html__('Database Version', 'goyo-statistics'),
                'value' => Option::getOptionGroup('db', 'version', '0.0.0'),
            ],
            'detectActiveCachePlugin'        => [
                'label' => esc_html__('Detect Active Cache Plugin', 'goyo-statistics'),
                /* translators: %s: string value */
                'value' => Helper::checkActiveCachePlugin()['status'] === true ? sprintf(__('Enabled (%s)', 'goyo-statistics'), Helper::checkActiveCachePlugin()['plugin']) : __('Disabled', 'goyo-statistics'),
                'debug' => Helper::checkActiveCachePlugin()['status'] === true ? 'Enabled ' . Helper::checkActiveCachePlugin()['debug'] : 'Disabled',
            ],
            'activePostTypes'                => [
                'label' => esc_html__('Active Post Types', 'goyo-statistics'),
                'value' => implode(', ', Helper::getPostTypes()),
            ],
            'dailySaltDate'                  => [
                'label' => esc_html__('Daily Salt Date', 'goyo-statistics'),
                'value' => is_array(get_option('goyo_statistics_daily_salt')) ? get_option('goyo_statistics_daily_salt')['date'] : '',
            ],

            /**
             * Plugin configuration settings.
             */
            'trackLoggedInUserActivity'      => [
                'label' => esc_html__('Track Logged-In User Activity', 'goyo-statistics'),
                'value' => Option::get('visitors_log') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('visitors_log') ? 'Enabled' : 'Disabled',
            ],
            'storeEntireUserAgentString'     => [
                'label' => esc_html__('Store Entire User Agent String', 'goyo-statistics'),
                'value' => Option::get('store_ua') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('store_ua') ? 'Enabled' : 'Disabled',
            ],
            'attributionModel'               => [
                'label' => esc_html__('Attribution Model', 'goyo-statistics'),
                'value' => Option::get('attribution_model', 'first-touch'),
                'debug' => Option::get('attribution_model', 'first-touch'),
            ],
            'trackingMethod'                 => [
                'label' => esc_html__('Tracking Method', 'goyo-statistics'),
                'value' => Option::get('use_cache_plugin') ? __('Client Side Tracking', 'goyo-statistics') : __('Server Side Tracking', 'goyo-statistics'),
                'debug' => Option::get('use_cache_plugin') ? 'Client Side Tracking' : 'Server Side Tracking',
            ],
            'bypassAdBlockers'               => [
                'label' => esc_html__('Bypass Ad Blockers', 'goyo-statistics'),
                'value' => Option::get('bypass_ad_blockers') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('bypass_ad_blockers') ? 'Enabled' : 'Disabled',
            ],
            'anonymizeIpAddresses'           => [
                'label' => esc_html__('Anonymize IP Addresses', 'goyo-statistics'),
                'value' => Option::get('anonymize_ips') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('anonymize_ips') ? 'Enabled' : 'Disabled',
            ],
            'hashIpAddresses'                => [
                'label' => esc_html__('Hash IP Addresses', 'goyo-statistics'),
                'value' => Option::get('hash_ips') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('hash_ips') ? 'Enabled' : 'Disabled',
            ],
            'viewStatsInEditor'              => [
                'label' => esc_html__('View Stats in Editor', 'goyo-statistics'),
                'value' => Option::get('disable_editor') ? __('Disabled', 'goyo-statistics') : __('Enabled', 'goyo-statistics'),
                'debug' => Option::get('disable_editor') ? 'Disabled' : 'Enabled',
            ],
            'viewsColumnInContentList'       => [
                'label' => esc_html__('Views Column in Content List', 'goyo-statistics'),
                'value' => Option::get('disable_column') ? __('Disabled', 'goyo-statistics') : __('Enabled', 'goyo-statistics'),
                'debug' => Option::get('disable_column') ? 'Disabled' : 'Enabled',
            ],
            'viewsColumnInUserList'          => [
                'label' => esc_html__('Views Column in User List', 'goyo-statistics'),
                'value' => Option::get('enable_user_column') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('enable_user_column') ? 'Enabled' : 'Disabled',
            ],
            'showStatsInAdminMenuBar'        => [
                'label' => esc_html__('Show Stats in Admin Menu Bar', 'goyo-statistics'),
                'value' => Option::get('menu_bar') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('menu_bar') ? 'Enabled' : 'Disabled',
            ],
            'goyoStatisticsChartsPrevPeriod'   => [
                'label' => esc_html__('Previous Period in Charts', 'goyo-statistics'),
                'value' => Option::get('charts_previous_period') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('charts_previous_period') ? 'Enabled' : 'Disabled',
            ],
            'goyoStatisticsWidgets'            => [
                'label' => esc_html__('WP Statistics Widgets in the WordPress dashboard', 'goyo-statistics'),
                'value' => Option::get('disable_dashboard') ? __('Disabled', 'goyo-statistics') : __('Enabled', 'goyo-statistics'),
                'debug' => Option::get('disable_dashboard') ? 'Disabled' : 'Enabled',
            ],
            'goyoStatisticsNotifications'      => [
                'label' => esc_html__('WP Statistics Notifications', 'goyo-statistics'),
                'value' => Option::get('display_notifications') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('display_notifications') ? 'Enabled' : 'Disabled',
            ],
            'disableInactiveFeatureNotices'  => [
                'label' => esc_html__('Disable Inactive Essential Feature Notices', 'goyo-statistics'),
                'value' => Option::get('hide_notices') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('hide_notices') ? 'Enabled' : 'Disabled',
            ],
            'viewsInSingleContents'          => [
                'label' => esc_html__('Views in Single Contents', 'goyo-statistics'),
                'value' => Option::get('show_hits') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('show_hits') ? 'Enabled' : 'Disabled',
            ],
            'reportFrequency'                => [
                'label' => esc_html__('Report Frequency', 'goyo-statistics'),
                'value' => Option::get('time_report') ? Option::get('time_report') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('time_report') ? Option::get('time_report') : 'Disabled',
            ],
            'userRoleExclusions'             => [
                'label' => esc_html__('User Role Exclusions', 'goyo-statistics'),
                'value' => $userRoleExclusions ? implode(', ', $userRoleExclusions) : __('Not Set', 'goyo-statistics'),
                'debug' => $userRoleExclusions ? implode(', ', $userRoleExclusions) : 'Not Set',
            ],
            'ipExclusions'                   => [
                'label' => esc_html__('IP Exclusions', 'goyo-statistics'),
                'value' => Option::get('exclude_ip') ? __('Set', 'goyo-statistics') : __('Not Set', 'goyo-statistics'),
                'debug' => Option::get('exclude_ip') ? 'Set' : 'Not Set',
            ],
            'excludedLoginPage'              => [
                'label' => esc_html__('Excluded Login Page', 'goyo-statistics'),
                'value' => Option::get('exclude_loginpage') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('exclude_loginpage') ? 'Enabled' : 'Disabled',
            ],
            'excludedRssFeeds'               => [
                'label' => esc_html__('Excluded RSS Feeds', 'goyo-statistics'),
                'value' => Option::get('exclude_feeds') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('exclude_feeds') ? 'Enabled' : 'Disabled',
            ],
            'excluded404Page'                => [
                'label' => esc_html__('Excluded 404 Pages', 'goyo-statistics'),
                'value' => Option::get('exclude_404s') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('exclude_404s') ? 'Enabled' : 'Disabled',
            ],
            'excludedURLs'                   => [
                'label' => esc_html__('Excluded URLs', 'goyo-statistics'),
                'value' => Option::get('excluded_urls') ? __('Set', 'goyo-statistics') : __('Not Set', 'goyo-statistics'),
                'debug' => Option::get('excluded_urls') ? 'Set' : 'Not Set',
            ],
            'logRecordExclusions'            => [
                'label' => esc_html__('Log Record Exclusions', 'goyo-statistics'),
                'value' => Option::get('record_exclusions') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('record_exclusions') ? 'Enabled' : 'Disabled',
            ],
            'minRoleToViewStats'             => [
                'label' => esc_html__('Minimum Role to View Statistics', 'goyo-statistics'),
                'value' => Option::get('read_capability') ? Option::get('read_capability') : __('Not Set', 'goyo-statistics'),
                'debug' => Option::get('read_capability') ? Option::get('read_capability') : 'Not Set',
            ],
            'minRoleToManageSettings'        => [
                'label' => esc_html__('Minimum Role to Manage Settings', 'goyo-statistics'),
                'value' => Option::get('manage_capability') ? Option::get('manage_capability') : __('Not Set', 'goyo-statistics'),
                'debug' => Option::get('manage_capability') ? Option::get('manage_capability') : 'Not Set',
            ],
            'ipDetectionMethod'              => [
                'label' => esc_html__('IP Detection Method', 'goyo-statistics'),
                'value' => Option::get('ip_method') ? Option::get('ip_method') : __('Not Set', 'goyo-statistics'),
                'debug' => Option::get('ip_method') ? Option::get('ip_method') : 'Not Set',
            ],
            'purgeDataOlderThan'             => [
                'label' => esc_html__('Purge Data Older Than', 'goyo-statistics'),
                'value' => Option::get('schedule_dbmaint_days') ? Option::get('schedule_dbmaint_days') : __('Not Set', 'goyo-statistics'),
                'debug' => Option::get('schedule_dbmaint_days') ? Option::get('schedule_dbmaint_days') : 'Not Set',
            ],
            'shareAnonymousData'             => [
                'label' => esc_html__('Share Anonymous Data', 'goyo-statistics'),
                'value' => Option::get('share_anonymous_data') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('share_anonymous_data') ? 'Enabled' : 'Disabled',
            ],
            'phpGmpExtension'                => [
                'label' => esc_html__('PHP Extension (GMP)', 'goyo-statistics'),
                'value' => extension_loaded('gmp') ? __('Installed', 'goyo-statistics') : __('Not Installed', 'goyo-statistics'),
                'debug' => extension_loaded('gmp') ? 'Installed' : 'Not Installed',
            ],
            'phpBcmathExtension'             => [
                'label' => esc_html__('PHP Extension (BCMath)', 'goyo-statistics'),
                'value' => extension_loaded('bcmath') ? __('Installed', 'goyo-statistics') : __('Not Installed', 'goyo-statistics'),
                'debug' => extension_loaded('bcmath') ? 'Installed' : 'Not Installed',
            ],
            'phpGzopenFunction'              => [
                'label' => esc_html__('PHP Function (gzopen)', 'goyo-statistics'),
                'value' => function_exists('gzopen') ? __('Installed', 'goyo-statistics') : __('Not Installed', 'goyo-statistics'),
                'debug' => function_exists('gzopen') ? 'Installed' : 'Not Installed',
            ],
            'phpPharDataClass'               => [
                'label' => esc_html__('PHP Class (PharData)', 'goyo-statistics'),
                'value' => class_exists('PharData') ? __('Installed', 'goyo-statistics') : __('Not Installed', 'goyo-statistics'),
                'debug' => class_exists('PharData') ? 'Installed' : 'Not Installed',
            ],
        ];

        $settings['consentIntegration'] = [
            'label' => esc_html__('Consent Integration', 'goyo-statistics'),
            'value' => !empty($consentIntegration) ? $consentIntegration : esc_html__('None', 'goyo-statistics'),
            'debug' => !empty($consentIntegration) ? $consentIntegration : 'None',
        ];

        if ($consentIntegration === 'borlabs_cookie') {
            $settings['anonymousTracking'] = [
                'label' => esc_html__('Anonymous Tracking', 'goyo-statistics'),
                'value' => Option::get('anonymous_tracking') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::get('anonymous_tracking') ? 'Enabled' : 'Disabled',
            ];
        }

        $settings['doNotTrack'] = [
            'label' => esc_html__('Do Not Track (DNT)', 'goyo-statistics'),
            'value' => Option::get('do_not_track') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
            'debug' => Option::get('do_not_track') ? 'Enabled' : 'Disabled',
        ];

        return $settings;
    }

    /**
     * Get settings for active add-ons.
     *
     * @return array
     */
    public function getAddOnsSettings()
    {
        $settings = [];

        /**
         * REST API
         */
        if (Helper::isAddOnActive('rest-api')) {
            $settings['apiServiceStatus'] = [
                'label' => esc_html__('API Service Status', 'goyo-statistics'),
                'value' => Option::getByAddon('status', 'rest_api') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('status', 'rest_api') ? 'Enabled' : 'Disabled',
            ];
        }

        /**
         * Advanced Reporting
         */
        if (Helper::isAddOnActive('advanced-reporting')) {
            $settings['chooseYourReportTiming']    = [
                'label' => esc_html__('Choose Your Report Timing', 'goyo-statistics'),
                'value' => Option::getByAddon('report_time_frame_type', 'advanced_reporting'),
            ];
            $settings['topMetrics']                = [
                'label' => esc_html__('Top Metrics', 'goyo-statistics'),
                'value' => Option::getByAddon('email_top_metrics', 'advanced_reporting') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('email_top_metrics', 'advanced_reporting') ? 'Enabled' : 'Disabled',
            ];
            $settings['visitorsSummary']           = [
                'label' => esc_html__('Visitors Summary', 'goyo-statistics'),
                'value' => Option::getByAddon('email_summary_stats', 'advanced_reporting') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('email_summary_stats', 'advanced_reporting') ? 'Enabled' : 'Disabled',
            ];
            $settings['viewsChart']                = [
                'label' => esc_html__('Views Chart', 'goyo-statistics'),
                'value' => Option::getByAddon('email_top_hits_visits', 'advanced_reporting') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('email_top_hits_visits', 'advanced_reporting') ? 'Enabled' : 'Disabled',
            ];
            $settings['searchEngineReferrals']     = [
                'label' => esc_html__('Search Engine Referrals', 'goyo-statistics'),
                'value' => Option::getByAddon('email_search_engine', 'advanced_reporting') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('email_search_engine', 'advanced_reporting') ? 'Enabled' : 'Disabled',
            ];
            $settings['searchEngineChart']         = [
                'label' => esc_html__('Search Engine Chart', 'goyo-statistics'),
                'value' => Option::getByAddon('email_top_search_engines', 'advanced_reporting') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('email_top_search_engines', 'advanced_reporting') ? 'Enabled' : 'Disabled',
            ];
            $settings['topReferringDomains']       = [
                'label' => esc_html__('Top Referring Domains', 'goyo-statistics'),
                'value' => Option::getByAddon('email_top_referring', 'advanced_reporting') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('email_top_referring', 'advanced_reporting') ? 'Enabled' : 'Disabled',
            ];
            $settings['topPages']                  = [
                'label' => esc_html__('Top Pages', 'goyo-statistics'),
                'value' => Option::getByAddon('email_top_ten_pages', 'advanced_reporting') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('email_top_ten_pages', 'advanced_reporting') ? 'Enabled' : 'Disabled',
            ];
            $settings['topCountries']              = [
                'label' => esc_html__('Top Countries', 'goyo-statistics'),
                'value' => Option::getByAddon('email_top_ten_countries', 'advanced_reporting') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('email_top_ten_countries', 'advanced_reporting') ? 'Enabled' : 'Disabled',
            ];
            $settings['topBrowsers']               = [
                'label' => esc_html__('Top Browsers', 'goyo-statistics'),
                'value' => Option::getByAddon('email_chart_top_browsers', 'advanced_reporting') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('email_chart_top_browsers', 'advanced_reporting') ? 'Enabled' : 'Disabled',
            ];
            $settings['moreInformationButton']     = [
                'label' => esc_html__('More Information Button', 'goyo-statistics'),
                'value' => Option::getByAddon('email_more_info_button', 'advanced_reporting') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('email_more_info_button', 'advanced_reporting') ? 'Enabled' : 'Disabled',
            ];
            $settings['auto-GeneratedNotice']      = [
                'label' => esc_html__('Auto-Generated Notice', 'goyo-statistics'),
                'value' => Option::getByAddon('email_disable_copyright', 'advanced_reporting') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('email_disable_copyright', 'advanced_reporting') ? 'Enabled' : 'Disabled',
            ];
            $settings['emailPDFReportAttachments'] = [
                'label' => esc_html__('Email PDF Report Attachments', 'goyo-statistics'),
                'value' => Option::getByAddon('pdf_report_status', 'advanced_reporting') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('pdf_report_status', 'advanced_reporting') ? 'Enabled' : 'Disabled',
            ];
            $settings['recordEmailLogs']           = [
                'label' => esc_html__('Record Email Logs', 'goyo-statistics'),
                'value' => Option::getByAddon('record_email_logs', 'advanced_reporting') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('record_email_logs', 'advanced_reporting') ? 'Enabled' : 'Disabled',
            ];
        }

        /**
         * Real-time Stats
         */
        if (Helper::isAddOnActive('realtime-stats')) {
            $settings['chartMapRefreshRate'] = [
                'label' => esc_html__('Chart & Map Refresh Rate (seconds)', 'goyo-statistics'),
                'value' => Option::getByAddon('interval_time', 'realtime_stats'),
            ];
        }

        /**
         * Advanced Widgets
         */
        if (Helper::isAddOnActive('widgets')) {
            $settings['refreshEvery']            = [
                'label' => esc_html__('Refresh Every', 'goyo-statistics'),
                'value' => Option::getByAddon('cache_life', 'widgets'),
            ];
            $settings['useDefaultWidgetStyling'] = [
                'label' => esc_html__('Use Default Widget Styling', 'goyo-statistics'),
                'value' => Option::getByAddon('disable_styles', 'widgets') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('disable_styles', 'widgets') ? 'Enabled' : 'Disabled',
            ];
        }

        /**
         * Customization
         */
        if (Helper::isAddOnActive('customization')) {
            $settings['whiteLabel']           = [
                'label' => esc_html__('White Label', 'goyo-statistics'),
                'value' => Option::getByAddon('goyostats_white_label', 'customization') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('goyostats_white_label', 'customization') ? 'Enabled' : 'Disabled',
            ];
            $settings['enableOverviewWidget'] = [
                'label' => esc_html__('Enable Overview Widget', 'goyo-statistics'),
                'value' => Option::getByAddon('show_wps_about_widget_overview', 'customization'),
            ];
        }

        /**
         * Data Plus
         */
        if (Helper::isAddOnActive('data-plus')) {
            $settings['linkTracker']            = [
                'label' => esc_html__('Link Tracker', 'goyo-statistics'),
                'value' => Option::getByAddon('link_tracker', 'data_plus', '1') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('link_tracker', 'data_plus', '1') ? 'Enabled' : 'Disabled',
            ];
            $settings['downloadTracker']        = [
                'label' => esc_html__('Download Tracker', 'goyo-statistics'),
                'value' => Option::getByAddon('download_tracker', 'data_plus', '1') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('download_tracker', 'data_plus', '1') ? 'Enabled' : 'Disabled',
            ];
            $settings['latestVisitorsInEditor'] = [
                'label' => esc_html__('Latest Visitors In Editor', 'goyo-statistics'),
                'value' => Option::getByAddon('latest_visitors_metabox', 'data_plus', '1') ? __('Enabled', 'goyo-statistics') : __('Disabled', 'goyo-statistics'),
                'debug' => Option::getByAddon('latest_visitors_metabox', 'data_plus', '1') ? 'Enabled' : 'Disabled',
            ];
        }

        /**
         * Mini Chart
         */
        if (Helper::isAddOnActive('mini-chart')) {
            $settings['chartMetric']    = [
                'label' => esc_html__('Chart Metric', 'goyo-statistics'),
                'value' => Option::getByAddon('metric', 'mini_chart', 'views'),
            ];
            $settings['chartDateRange'] = [
                'label' => esc_html__('Chart Date Range', 'goyo-statistics'),
                'value' => Option::getByAddon('date_range', 'mini_chart', '14'),
            ];
            $settings['countDisplay']   = [
                'label' => esc_html__('Count Display', 'goyo-statistics'),
                'value' => Option::getByAddon('count_display', 'mini_chart', 'total'),
            ];
        }

        return $settings;
    }

    /**
     * Get the user role exclusions.
     *
     * @param bool $translate
     *
     * @return array
     */
    public function getUserRoleExclusions($translate = true)
    {
        $excludeRoles = [];
        foreach (\GOYO_STATISTICS\User::get_role_list() as $role) {
            $optionName = 'exclude_' . str_replace(" ", "_", strtolower($role));

            if (Option::get($optionName)) {
                if ($translate) {
                    $translatedRoleName = ($role === 'Anonymous Users') ? __('Anonymous Users', 'goyo-statistics') : translate_user_role($role);
                } else {
                    $translatedRoleName = ($role === 'Anonymous Users') ? 'Anonymous Users' : $role;
                }
                $excludeRoles[] = $translatedRoleName;
            }
        }

        return $excludeRoles;
    }
}
