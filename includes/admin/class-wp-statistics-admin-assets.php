<?php

namespace GOYO_STATISTICS;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Utils\Request;
use Goyo_Statistics\Components\Assets;
use Goyo_Statistics\Components\DateRange;
use Goyo_Statistics\Components\DateTime;
use Goyo_Statistics\Globals\Context;
use Goyo_Statistics\Service\Admin\Metabox\MetaboxHelper;
use Goyo_Statistics\Service\Admin\Optimization\OptimizationActions;

class Admin_Assets
{
    /**
     * Prefix Of Load Css/Js in WordPress Admin
     *
     * @var string
     */
    public static $prefix = 'goyo-statistics-admin';

    /**
     * Suffix Of Minify File in Assets
     *
     * @var string
     */
    public static $suffix_min = '.min';

    /**
     * Assets Folder name in Plugin
     *
     * @var string
     */
    public static $asset_dir = 'assets';

    /**
     * Basic Of Plugin Url in WordPress
     *
     * @var string
     * @example http://site.com/wp-content/plugins/my-plugin/
     */
    public static $plugin_url = GOYO_STATISTICS_URL;

    /**
     * Current Asset Version for this plugin
     *
     * @var string
     */
    public static $asset_version = GOYO_STATISTICS_VERSION;

    /**
     * Admin_Assets constructor.
     */
    public function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'admin_styles'), 999);
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'), 999);
        add_filter('goyo_statistics_enqueue_chartjs', [$this, 'shouldEnqueueChartJs']);
    }


    /**
     * Get Version of File
     *
     * @param $ver
     * @return bool
     */
    public static function version($ver = false)
    {
        if ($ver) {
            return $ver;
        } else {
            if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) {
                return time();
            } else {
                return self::$asset_version;
            }
        }
    }

    /**
     * Localize jquery datepicker
     *
     * @see https://gist.github.com/mehrshaddarzi/7f661baeb5d801961deb8b821157e820
     */
    public static function localize_jquery_datepicker()
    {
        global $wp_locale;

        return array(
            'closeText'       => __('Action Completed', 'goyo-statistics'),
            'currentText'     => __('Today', 'goyo-statistics'),
            'monthNames'      => Helper::strip_array_indices($wp_locale->month),
            'monthNamesShort' => Helper::strip_array_indices($wp_locale->month_abbrev),
            'monthStatus'     => __('Display Other Month', 'goyo-statistics'),
            'dayNames'        => Helper::strip_array_indices($wp_locale->weekday),
            'dayNamesShort'   => Helper::strip_array_indices($wp_locale->weekday_abbrev),
            'dayNamesMin'     => Helper::strip_array_indices($wp_locale->weekday_initial),
            'dateFormat'      => 'yy-mm-dd', // Format time for Jquery UI
            'firstDay'        => get_option('start_of_week'),
            'isRTL'           => $wp_locale->is_rtl(),
        );
    }

    /**
     * Enqueue dashboard page styles.
     */

    public function dashboard_styles()
    {
        // Load Dashboard Css
        wp_enqueue_style(self::$prefix . '-dashboard', self::url('dashboard.min.css'), array(), self::version());
    }

    /**
     * Get Asset Url
     *
     * @param $file_name
     * @return string
     */
    public static function url($file_name)
    {

        // Get file Extension Type
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if ($ext != "js" and $ext != "css") {
            $ext = 'images';
        }

        // Prepare File Path
        $path = self::$asset_dir . '/' . $ext . '/';

        // Prepare Full Url
        $url = self::$plugin_url . $path;

        // Return Url
        return $url . $file_name;
    }

    /**
     * Enqueue styles.
     */
    public function admin_styles()
    {
        if (!User::hasPageAccess()) {
            return;
        }

        // Get Current Screen ID
        $screen_id = Helper::get_screen_id();

        // Load Admin Css
        wp_enqueue_style(self::$prefix, self::url('admin.min.css'), array(), self::version() . '.' . filemtime(GOYO_STATISTICS_DIR . 'assets/css/admin.min.css'));

        // Load Rtl Version Css
        if (is_rtl()) {
            wp_enqueue_style(self::$prefix . '-rtl', self::url('rtl.min.css'), array(), self::version());
        }

        //Load Jquery VMap Css
        if (Menus::in_page('overview') || Menus::in_page('pages') || Menus::in_page('geographic') || Menus::in_page('visitors') || (in_array($screen_id, array('dashboard')) and !Option::get('disable_dashboard'))) {
            wp_enqueue_style(self::$prefix . '-jqvmap', self::url('jqvmap/jqvmap.min.css'), array(), '1.5.1');
        }

        // Load Jquery-ui theme
        //        if (Menus::in_plugin_page() and Menus::in_page('optimization') === false and Menus::in_page('settings') === false) {
        //            wp_enqueue_style(self::$prefix . '-jquery-datepicker', self::url('datepicker.min.css'), array(), '1.11.4');
        //        }

        // Load Select2
        if (Menus::in_page('visitors') || Menus::in_page('referrals') || Menus::in_page('link_tracker') || Menus::in_page('download_tracker') || Menus::in_page('pages') || Menus::in_page('settings') || Menus::in_page('optimization') || Menus::in_page('goals')) {
            wp_enqueue_style(self::$prefix . '-select2', self::url('select2/select2.min.css'), array(), '4.0.9');
        }

        // Load RangeDatePicker
        if (Menus::in_plugin_page() || Menus::in_page('pages') || in_array($screen_id, array('dashboard'))) {
            wp_enqueue_style(self::$prefix . '-daterangepicker', self::url('datepicker/daterangepicker.css'), array(), '1.0.1');
            wp_enqueue_style(self::$prefix . '-customize', self::url('datepicker/customize.css'), array(), '1.0.0');
        }
    }

    /**
     * Enqueue scripts.
     *
     * @param $hook [ Page Now ]
     */
    public function admin_scripts($hook)
    {
        if (!User::hasPageAccess()) {
            return;
        }

        // Get Current Screen ID
        $screen_id = Helper::get_screen_id();

        if (Menus::in_plugin_page() || in_array($screen_id, ['dashboard'])) {
            Assets::script('option-updater', 'js/option-updater.js', [], [
                'admin_url' => admin_url(),
                'nonce'     => wp_create_nonce('wp_rest')
            ], true);
        }

        // Load Chart.js library
        if (apply_filters('goyo_statistics_enqueue_chartjs', false)) {
            Assets::script('chart.js', 'js/chartjs/chart.umd.min.js', [], [], true, false, null, '4.4.4');
        }

        // Load mini-chart
        if (Helper::isAdminBarShowing()) {
            Assets::script('mini-chart', 'js/mini-chart.js', [], [], true);
        }

        if (Menus::in_page('author-analytics')) {
            wp_enqueue_script(self::$prefix . '-chart-matrix.js', self::url('chartjs/chart-matrix.min.js'), [], '2.0.8', true);
        }

        // Load Jquery VMap Js Library
        if (Menus::in_page('overview') || Menus::in_page('pages') || Menus::in_page('geographic') || Menus::in_page('visitors') || (in_array($screen_id, array('dashboard')) and !Option::get('disable_dashboard'))) {
            wp_enqueue_script(self::$prefix . '-jqvmap', self::url('jqvmap/jquery.vmap.min.js'), array('jquery'), "1.5.1", ['in_footer' => true]);
            wp_enqueue_script(self::$prefix . '-jqvmap-world', self::url('jqvmap/jquery.vmap.world.min.js'), array('jquery'), "1.5.1", ['in_footer' => true]);
        }


        // Load Jquery UI
        //        if (Menus::in_plugin_page() and Menus::in_page('optimization') === false and Menus::in_page('settings') === false) {
        //            wp_enqueue_script('jquery-ui-datepicker');
        //            wp_localize_script('jquery-ui-datepicker', 'goyostats_i18n_jquery_datepicker', self::localize_jquery_datepicker());
        //        }

        // Load Select2
        if (Menus::in_page('visitors') || Menus::in_page('referrals') || Menus::in_page('link_tracker') || Menus::in_page('download_tracker') || Menus::in_page('pages') || Menus::in_page('settings') || Menus::in_page('optimization') || Menus::in_page('goals')) {
            wp_enqueue_script(self::$prefix . '-select2', self::url('select2/select2.full.min.js'), array('jquery'), "4.1.0", ['in_footer' => true]);
        }

        // Load WordPress PostBox Script
        if (Menus::in_plugin_page() and Menus::in_page('optimization') === false and Menus::in_page('settings') === false) {
            wp_enqueue_script('common');
            wp_enqueue_script('wp-lists');
            wp_enqueue_script('postbox');
        }

        if (Menus::in_page('settings')) {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wp-color-picker');
        }

        // Load Admin Js
        if (
            Menus::in_plugin_page() || (in_array($screen_id, ['dashboard']) && !Option::get('disable_dashboard')) ||
            (in_array($hook, ['post.php', 'edit.php']) && !Option::get('disable_editor')) ||
            (in_array($hook, ['post.php', 'edit.php']) && Helper::isAddOnActive('data-plus') && Option::getByAddon('latest_visitors_metabox', 'data_plus', '1') === '1')
        ) {
            wp_enqueue_script(self::$prefix, self::url('admin.min.js'), array('jquery'), self::version() . '.' . filemtime(GOYO_STATISTICS_DIR . 'assets/js/admin.min.js'), ['in_footer' => true]);
            wp_localize_script(self::$prefix, 'goyostats_global', self::goyostats_global($hook));
        }

        // Add Thick box
        if (Menus::in_page('visitors') || Menus::in_page('visitors-report') || Menus::in_page('referrals') || Menus::in_page('pages')) {
            wp_enqueue_script('thickbox');
            wp_enqueue_style('thickbox');
        }

        // Add RangeDatePicker (moment is shipped by WordPress core; daterangepicker depends on it)
        if (Menus::in_plugin_page() || Menus::in_page('pages') || in_array($screen_id, array('dashboard'))) {
            wp_enqueue_script('moment');
            wp_enqueue_script(self::$prefix . '-daterangepicker', self::url('datepicker/daterangepicker.min.js'), array('moment'), "1.13.2", ['in_footer' => true]);
        }

        if (Menus::in_page('pages')) {
            wp_enqueue_script(self::$prefix . '-datepicker', self::url('datepicker/datepicker.js'), array(), self::version(), ['in_footer' => true]);
        }
    }

    /**
     * Prepare global WP Statistics data for use Admin Js
     *
     * @param $hook
     * @return mixed
     */
    public static function goyostats_global($hook)
    {
        global $post;

        //Global Option
        $list['options'] = array(
            'rtl'            => (is_rtl() ? 1 : 0),
            'user_online'    => 1,
            'visitors'       => 1,
            'visits'         => 1,
            'geo_ip'         => 1,
            'geo_city'       => 1,
            'overview_page'  => (Menus::in_page('overview') ? 1 : 0),
            'gutenberg'      => (Helper::is_gutenberg() ? 1 : 0),
            'more_btn'       => (apply_filters('goyo_statistics_meta_box_more_button', true) ? 1 : 0),
            'wp_date_format' => Helper::getDefaultDateFormat(),
            'track_users'    => Option::get('visitors_log') ? 1 : 0,
            'wp_timezone'    => DateTime::getTimezone()->getName()
        );


        // WordPress Current Page
        $list['page'] = array(
            'file' => $hook,
            'ID'   => (isset($post) ? $post->ID : 0)
        );

        // WordPress Admin Page request Params
        if (isset($_GET)) {
            foreach ($_GET as $key => $value) {
                if ($key == "page") {
                    $slug  = Menus::getPageKeyFromSlug(esc_html($value));
                    $value = $slug[0];
                }
                if (!is_array($value)) {
                    $list['request_params'][esc_html($key)] = esc_html($value);
                } else {
                    // Ensure each value in the array is escaped properly
                    $value = array_map('esc_html', $value);
                    // Assign the entire escaped array to the request_params array
                    $list['request_params'][esc_html($key)] = $value;
                }
            }
        }

        // Global Lang
        $list['i18n'] = array(
            'more_detail'                  => __('View Details', 'goyo-statistics'),
            'reload'                       => __('Reload', 'goyo-statistics'),
            'online_users'                 => __('Online Visitors', 'goyo-statistics'),
            'Realtime'                     => __('Realtime', 'goyo-statistics'),
            'visitors'                     => __('Visitors', 'goyo-statistics'),
            'visits'                       => __('Views', 'goyo-statistics'),
            'today'                        => __('Today', 'goyo-statistics'),
            'yesterday'                    => __('Yesterday', 'goyo-statistics'),
            'week'                         => __('Last 7 days', 'goyo-statistics'),
            'this-week'                    => __('This week', 'goyo-statistics'),
            'last-week'                    => __('Last week', 'goyo-statistics'),
            'month'                        => __('Last 30 days', 'goyo-statistics'),
            'this-month'                   => __('This month', 'goyo-statistics'),
            'last-month'                   => __('Last month', 'goyo-statistics'),
            '7days'                        => __('Last 7 days', 'goyo-statistics'),
            '30days'                       => __('Last 30 days', 'goyo-statistics'),
            '60days'                       => __('Last 60 days', 'goyo-statistics'),
            '90days'                       => __('Last 90 days', 'goyo-statistics'),
            '6months'                      => __('Last 6 months', 'goyo-statistics'),
            'year'                         => __('Last 12 months', 'goyo-statistics'),
            'this-year'                    => __('This year (Jan-Today)', 'goyo-statistics'),
            'last-year'                    => __('Last year', 'goyo-statistics'),
            'total'                        => __('Total', 'goyo-statistics'),
            'daily_total'                  => __('Daily Total', 'goyo-statistics'),
            'date'                         => __('Date', 'goyo-statistics'),
            'time'                         => __('Time', 'goyo-statistics'),
            'browsers'                     => __('Browsers', 'goyo-statistics'),
            'rank'                         => __('#', 'goyo-statistics'),
            'flag'                         => __('Country Flag', 'goyo-statistics'),
            'country'                      => __('Country', 'goyo-statistics'),
            'visitor_count'                => __('Visitors', 'goyo-statistics'),
            'id'                           => __('ID', 'goyo-statistics'),
            'title'                        => __('Page', 'goyo-statistics'),
            'link'                         => __('Page Link', 'goyo-statistics'),
            'address'                      => __('Domain Address', 'goyo-statistics'),
            'word'                         => __('Search Term', 'goyo-statistics'),
            'browser'                      => __('Visitor\'s Browser', 'goyo-statistics'),
            'city'                         => __('Visitor\'s City', 'goyo-statistics'),
            'ip'                           => Option::get('hash_ips') == true ? __('Daily Visitor Hash', 'goyo-statistics') : __('IP Address', 'goyo-statistics'),
            'ip_hash'                      => __('IP Address/Hash', 'goyo-statistics'),
            'ip_hash_placeholder'          => __('Enter IP (e.g., 192.168.1.1) or hash (#...)', 'goyo-statistics'),
            'referring_site'               => __('Referring Site', 'goyo-statistics'),
            'hits'                         => __('Views', 'goyo-statistics'),
            'agent'                        => __('User Agent', 'goyo-statistics'),
            'platform'                     => __('Operating System', 'goyo-statistics'),
            'version'                      => __('Browser/OS Version', 'goyo-statistics'),
            'page'                         => __('Visited Page', 'goyo-statistics'),
            'str_today'                    => __('Today', 'goyo-statistics'),
            'str_yesterday'                => __('Yesterday', 'goyo-statistics'),
            'str_this_week'                => __('This week', 'goyo-statistics'),
            'str_last_week'                => __('Last week', 'goyo-statistics'),
            'str_this_month'               => __('This month', 'goyo-statistics'),
            'str_last_month'               => __('Last month', 'goyo-statistics'),
            'str_7days'                    => __('Last 7 days', 'goyo-statistics'),
            'str_28days'                   => __('Last 28 days', 'goyo-statistics'),
            'str_30days'                   => __('Last 30 days', 'goyo-statistics'),
            'str_90days'                   => __('Last 90 days', 'goyo-statistics'),
            'str_6months'                  => __('Last 6 months', 'goyo-statistics'),
            'str_year'                     => __('This year', 'goyo-statistics'),
            'str_this_year'                => __('This year', 'goyo-statistics'),
            'str_last_year'                => __('Last year', 'goyo-statistics'),
            'str_back'                     => __('Go Back', 'goyo-statistics'),
            'str_custom'                   => __('Select Custom Range...', 'goyo-statistics'),
            'custom_range'                 => __('Custom Range', 'goyo-statistics'),
            'all_time'                     => __('All time', 'goyo-statistics'),
            'str_more'                     => __('Additional Date Ranges', 'goyo-statistics'),
            'custom'                       => __('Custom Date Range', 'goyo-statistics'),
            'to'                           => __('To (End Date)', 'goyo-statistics'),
            'from'                         => __('From (Start Date)', 'goyo-statistics'),
            'go'                           => __('Apply Range', 'goyo-statistics'),
            'no_data'                      => __('Sorry, there\'s no data available for this selection.', 'goyo-statistics'),
            'count'                        => __('Total Number', 'goyo-statistics'),
            'percentage'                   => __('Percent Share', 'goyo-statistics'),
            'version_list'                 => __('Version', 'goyo-statistics'),
            'filter'                       => __('Apply Filters', 'goyo-statistics'),
            'filters'                      => __('Filters', 'goyo-statistics'),
            'all'                          => __('All', 'goyo-statistics'),
            'er_datepicker'                => __('Select Desired Time Range', 'goyo-statistics'),
            'er_valid_ip'                  => __('Please enter a valid IP (e.g., 192.168.1.1) or hash (starting with #)', 'goyo-statistics'),
            'please_wait'                  => __('Loading, Please Wait...', 'goyo-statistics'),
            'user'                         => __('User', 'goyo-statistics'),
            'rest_connect'                 => __('Failed to retrieve data. Please check the browser console and the XHR request under Network → XHR for details.', 'goyo-statistics'),
            'privacy_compliant'            => __('Your WP Statistics settings are privacy-compliant.', 'goyo-statistics'),
            'non_privacy_compliant'        => __('Your WP Statistics settings are not privacy-compliant. Please update your settings.', 'goyo-statistics'),
            'no_result'                    => __('No recent data available.', 'goyo-statistics'),
            'published'                    => __('Published', 'goyo-statistics'),
            'author'                       => __('Author', 'goyo-statistics'),
            'view_detailed_analytics'      => __('View Detailed Analytics', 'goyo-statistics'),
            'enable_now'                   => __('Enable Now', 'goyo-statistics'),
            'receive_weekly_email_reports' => __('Receive Weekly Email Reports', 'goyo-statistics'),
            'close'                        => __('Close', 'goyo-statistics'),
            'previous_period'              => __('Previous period', 'goyo-statistics'),
            'view_content'                 => __('View Content', 'goyo-statistics'),
            'downloading'                  => __('Downloading', 'goyo-statistics'),
            'activated'                    => __('Activated', 'goyo-statistics'),
            'active'                       => __('Active', 'goyo-statistics'),
            'activating'                   => __('Activating', 'goyo-statistics'),
            'already_installed'            => __('Already installed', 'goyo-statistics'),
            'failed'                       => __('Failed', 'goyo-statistics'),
            'retry'                        => __('Retry', 'goyo-statistics'),
            'redirecting'                  => __('Redirecting... Please wait', 'goyo-statistics'),
            'last_view'                    => __('Last View', 'goyo-statistics'),
            'visitor_info'                 => __('Visitor Info', 'goyo-statistics'),
            'location'                     => __('Location', 'goyo-statistics'),
            'name'                         => __('Name', 'goyo-statistics'),
            'email'                        => __('Email', 'goyo-statistics'),
            'role'                         => __('Role', 'goyo-statistics'),
            'latest_page'                  => __('Latest Page', 'goyo-statistics'),
            'referrer'                     => __('Referrer', 'goyo-statistics'),
            'source_channel'               => __('Source Category', 'goyo-statistics'),
            'online_for'                   => __('Online For', 'goyo-statistics'),
            'views'                        => __('Views', 'goyo-statistics'),
            'view'                         => __('View', 'goyo-statistics'),
            'waiting'                      => __('Waiting', 'goyo-statistics'),
            'apply'                        => __('Apply', 'goyo-statistics'),
            'reset'                        => __('Reset', 'goyo-statistics'),
            'loading'                      => __('Loading', 'goyo-statistics'),
            'go_to_overview'               => __('Go to Overview', 'goyo-statistics'),
            'continue_to_next_step'        => __('Continue to Next Step', 'goyo-statistics'),
            'action_required'              => __('Action Required', 'goyo-statistics'),
            'show_less'                    => __('Show less', 'goyo-statistics'),
            'show_more'                    => __('Show more', 'goyo-statistics'),
            'pending'                      => __('Pending', 'goyo-statistics'),
            'copied'                       => __('Copied!', 'goyo-statistics'),
            'settings'                     => __('SETTINGS', 'goyo-statistics'),
            'premium_addons'               => __('PREMIUM ADD-ONS', 'goyo-statistics'),
            'forever'                      => __('Forever', 'goyo-statistics'),
            'days'                         => __('days', 'goyo-statistics'),
            'clicks'                       => __('Clicks', 'goyo-statistics'),
            'impressions'                  => __('Impressions', 'goyo-statistics'),
            'prev'                         => __('Prev', 'goyo-statistics'),
            'next'                         => __('Next', 'goyo-statistics'),
            'loading_error'                => __('Oops, something went wrong while loading statistics.', 'goyo-statistics'),
            'last_updated'                 => __('Last updated:', 'goyo-statistics'),
            'unassigned'                   => __('Unassigned', 'goyo-statistics'),
            'select_page'                  => __('Select page', 'goyo-statistics'),
            'daily'                        => __('Daily', 'goyo-statistics'),
            'weekly'                       => __('Weekly', 'goyo-statistics'),
            'monthly'                      => __('Monthly', 'goyo-statistics'),
            'required_error'               => __('This field is required', 'goyo-statistics'),
            'validate_error'               => __('Must not contain spaces, #, or .', 'goyo-statistics'),
            'machine_validate_error'       => __('Please use lowercase letters, numbers, underscores, or dashes only. No spaces allowed.', 'goyo-statistics'),
            'start_of_week'                => get_option('start_of_week', 0),
            'confirm_refresh_country'      => __('Are you sure you want to refresh country data?', 'goyo-statistics'),
            'confirm_update_channel'       => __('Are you sure you want to update and correct any unidentified source channels in the database?', 'goyo-statistics'),
            'confirm_hash_ips'             => __('This will replace all IP addresses in the database with hash values and cannot be undone, are you sure?', 'goyo-statistics'),
            'no_data_this_range'           => __('No data found for this date range.', 'goyo-statistics'),
            'coming_soon'                  => __('Data coming soon!', 'goyo-statistics'),
            'confirm_repair_schema'        => __('Are you sure you want to repair the schema issues?', 'goyo-statistics'),
            'operation_completed'          => __('Operation completed.', 'goyo-statistics'),
            'to_range'                     => __('to', 'goyo-statistics'),
            'are_you_sure'                 => __('Are you sure?', 'goyo-statistics'),
        );

        $list['active_post_type'] = Helper::getPostTypeName(Request::get('pt', 'post'));
        $list['user_date_range']  = DateRange::get();

        $list['initial_post_date'] = Helper::getInitialPostDate();

        if (Request::has('post_id')) {
            $list['post_creation_date'] = get_post_time(DateTime::$defaultDateFormat, false, Request::get('post_id'), false);
        } else if (is_singular()) {
            $list['post_creation_date'] = get_post_time(DateTime::$defaultDateFormat, false, null, false);
        }

        // Rest-API Meta Box Url
        $list['stats_report_option'] = Option::get('time_report') == '0' ? false : true;
        $list['setting_url']         = Menus::admin_url('settings');
        $list['admin_url']           = admin_url();
        $list['ajax_url']            = admin_url('admin-ajax.php');
        $list['assets_url']          = self::$plugin_url . self::$asset_dir;
        $list['rest_api_nonce']      = wp_create_nonce('wp_rest');
        $list['optimization_nonce']  = wp_create_nonce(OptimizationActions::NONCE_ACTION);
        $list['meta_box_api']        = admin_url('admin-ajax.php?action=goyo_statistics_admin_meta_box');

        // Rest-API Export/Import Url
        $list['export_url'] = rest_url('goyo-statistics/v2/export/');
        $list['import_url'] = rest_url('goyo-statistics/v2/import/');

        // For developers: WordPress debugging mode.
        $list['wp_debug'] = defined('WP_DEBUG') && WP_DEBUG ? true : false;

        $list['meta_boxes'] = User::Access('read') ? MetaboxHelper::getScreenMetaboxes() : [];

        $list['goyostats_page'] = Context::get('goyostats_page');

        /**
         * Filter: goyo_statistics_admin_assets
         *
         * @since 14.9.4
         */
        return apply_filters('goyo_statistics_admin_assets', $list);
    }

    /**
     * Checks if any of the conditions for enqueuing Chart.js library are met.
     *
     * Conditions are:
     * - Mini Chart add-on is enabled and admin bar button is showing.
     * - User is currently viewing the WP Statistics admin pages (e.g. Settings, Overview, Optimization, etc.).
     * - User is currently viewing WP dashboard and `disable_dashboard` option is not disabled.
     * - User is currently in edit post page and `disable_editor` is disabled.
     * - User is currently in edit post page and `latest_visitors_metabox` is enabled.
     *
     * @return  bool
     *
     * @hooked  filter: `goyo_statistics_enqueue_chartjs` - 10
     */
    public function shouldEnqueueChartJs()
    {
        global $pagenow;

        return (Helper::isAddOnActive('mini-chart') && Helper::isAdminBarShowing()) || Menus::in_plugin_page() ||
            (in_array(Helper::get_screen_id(), ['dashboard']) && !Option::get('disable_dashboard')) ||
            (in_array($pagenow, ['post.php', 'edit.php']) && !Option::get('disable_editor')) ||
            (in_array($pagenow, ['post.php', 'edit.php']) && Helper::isAddOnActive('data-plus') && Option::getByAddon('latest_visitors_metabox', 'data_plus', '1') === '1');
    }
}

new Admin_Assets;
