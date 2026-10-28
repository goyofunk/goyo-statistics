<?php
/** Local branding and free-feature policy for Goyo Statistics. */
defined('ABSPATH') || exit;

function goyo_statistics_template_enabled($template)
{
    $template = trim(preg_replace('#/+#', '/', $template), '/');
    $excluded = [
        'layout/footer', 'layout/partials/addon-premium-feature',
        'layout/partials/data-plus-locked-page', 'layout/filters/query-params-filter',
        'pages/lock-page', 'components/locked-page', 'components/objects/export-button',
        'components/notices/upgrade-to-premium', 'components/objects/share-anonymous-notice',
        'metabox/about', 'metabox/go-premium', 'metabox/action-button',
        'components/meta-box/enable-mail',
    ];
    return !in_array($template, $excluded, true)
        && strpos($template, 'components/lock-sections/') !== 0
        && strpos($template, 'components/modals/introduce-premium/') !== 0
        && strpos($template, 'components/modals/welcome-premium/') !== 0
        && strpos($template, 'pages/license-manager/') !== 0
        && strpos($template, 'settings/add-ons/') !== 0;
}

foreach ([
    'goyo_statistics_enable_header_addons_menu', 'goyo_statistics_enable_upgrade_to_bundle',
    'goyo_statistics_enable_help_icon', 'goyo_statistics_enable_footer_logo',
    'goyo_statistics_enable_footer_text', 'goyo_statistics_option_display_notifications',
] as $hook) {
    add_filter($hook, '__return_false', PHP_INT_MAX);
}

add_filter('goyo_statistics_admin_menu_list', '__return_empty_array', PHP_INT_MAX);

// Only these three dashboard widgets register their display and AJAX handlers.
add_filter('goyo_statistics_metabox_list', function ($items) {
    $namespace = 'Goyo_Statistics\\Service\\Admin\\Metabox\\Metaboxes\\';
    return [$namespace . 'TrafficOverview', $namespace . 'DailyTrafficTrend', $namespace . 'MostVisitedPages', $namespace . 'TopCities'];
}, PHP_INT_MAX);

add_filter('plugin_row_meta', function ($links, $file) {
    if ($file === plugin_basename(dirname(__DIR__) . '/wp-statistics.php')) {
        return ['버전 1.01', '작성자: 고용펑크'];
    }
    return $links;
}, PHP_INT_MAX, 2);

function goyo_statistics_remove_updates($updates)
{
    if (is_object($updates)) {
        $file = plugin_basename(dirname(__DIR__) . '/wp-statistics.php');
        unset($updates->response[$file], $updates->no_update[$file]);
    }
    return $updates;
}
add_filter('site_transient_update_plugins', 'goyo_statistics_remove_updates', PHP_INT_MAX);
add_filter('pre_set_site_transient_update_plugins', 'goyo_statistics_remove_updates', PHP_INT_MAX);

add_filter('auto_update_plugin', function ($update, $item) {
    return isset($item->plugin) && $item->plugin === plugin_basename(dirname(__DIR__) . '/wp-statistics.php') ? false : $update;
}, PHP_INT_MAX, 2);

add_filter('plugin_auto_update_setting_html', function ($html, $file) {
    return $file === plugin_basename(dirname(__DIR__) . '/wp-statistics.php') ? '' : $html;
}, PHP_INT_MAX, 2);

add_filter('http_request_args', function ($args, $url) {
    if (strpos($url, '://api.wordpress.org/plugins/update-check/') === false || empty($args['body']['plugins'])) return $args;
    $plugins = json_decode($args['body']['plugins'], true);
    if (!is_array($plugins)) return $args;
    $file = plugin_basename(dirname(__DIR__) . '/wp-statistics.php');
    unset($plugins['plugins'][$file]);
    if (isset($plugins['active'])) $plugins['active'] = array_values(array_diff($plugins['active'], [$file]));
    $args['body']['plugins'] = wp_json_encode($plugins);
    return $args;
}, PHP_INT_MAX, 2);

// Keep this plugin Korean even when the administrator uses another UI language.
add_filter('plugin_locale', function ($locale, $domain) {
    return $domain === 'goyo-statistics' ? 'ko_KR' : $locale;
}, PHP_INT_MAX, 2);
add_filter('load_textdomain_mofile', function ($file, $domain) {
    return $domain === 'goyo-statistics' ? __DIR__ . '/../languages/wp-statistics-ko_KR.mo' : $file;
}, PHP_INT_MAX, 2);

// Runtime-only preferences: preserve stored data and keep unrelated UI disabled.
function goyo_statistics_dashboard_options($options)
{
    $options = is_array($options) ? $options : [];
    return array_merge($options, [
        'disable_dashboard' => false,
        'use_cache_plugin' => true,
        'disable_column' => true,
        'enable_user_column' => false,
        'menu_bar' => false,
        'display_notifications' => false,
        'share_anonymous_data' => false,
        'word_count_analytics' => false,
        'time_report' => '0',
        'delete_data_on_uninstall' => false,
        'schedule_dbmaint' => false,
        'schedule_dbmaint_days' => '0',
    ]);
}
add_filter('goyo_statistics_runtime_options', 'goyo_statistics_dashboard_options', PHP_INT_MAX);
add_filter('goyo_statistics_show_admin_bar', '__return_false', PHP_INT_MAX);
add_filter('goyo_statistics_meta_box_more_button', '__return_false', PHP_INT_MAX);
add_filter('goyo_statistics_admin_notices', '__return_empty_array', PHP_INT_MAX);

// Ensure the requested widgets are visible without altering other dashboard widgets.
add_filter('hidden_meta_boxes', function ($hidden, $screen) {
    if ($screen->id !== 'dashboard') return $hidden;
    return array_values(array_diff($hidden, [
        'goyo-statistics-quickstats-widget', 'goyo-statistics-hits-widget', 'goyo-statistics-pages-widget', 'goyo-statistics-top-cities-widget',
    ]));
}, PHP_INT_MAX, 2);

add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook !== 'index.php') return;
    wp_enqueue_style('goyo-statistics-dashboard', plugins_url('assets/css/goyo-dashboard.css', dirname(__DIR__) . '/wp-statistics.php'), [], '1.01.' . filemtime(__DIR__ . '/../assets/css/goyo-dashboard.css'));
});

// Old scheduled retention jobs must not remove data after a reactivation.
add_action('init', function () {
    remove_all_actions('goyo_statistics_dbmaint_hook');
    remove_all_actions('goyo_statistics_dbmaint_visitor_hook');
}, PHP_INT_MAX);

require_once __DIR__ . '/goyo-statistics-reset.php';
