<?php

use Goyo_Statistics\Core\CoreFactory;
use Goyo_Statistics\Service\Admin\AnonymizedUsageData\AnonymizedUsageDataManager;
use Goyo_Statistics\Service\Admin\AuthorAnalytics\AuthorAnalyticsManager;
use Goyo_Statistics\Service\Admin\CategoryAnalytics\CategoryAnalyticsManager;
use Goyo_Statistics\Service\Admin\ContentAnalytics\ContentAnalyticsManager;
use Goyo_Statistics\Service\Admin\Devices\DevicesManager;
use Goyo_Statistics\Service\Admin\Exclusions\ExclusionsManager;
use Goyo_Statistics\Service\Admin\FilterHandler\FilterManager;
use Goyo_Statistics\Service\Admin\Geographic\GeographicManager;
use Goyo_Statistics\Service\Admin\LicenseManagement\LicenseManagementManager;
use Goyo_Statistics\Service\Admin\Metabox\MetaboxManager;
use Goyo_Statistics\Service\Admin\NoticeHandler\Notice;
use Goyo_Statistics\Service\Admin\Notification\NotificationManager;
use Goyo_Statistics\Service\Admin\MarketingCampaign\MarketingCampaignManager;
use Goyo_Statistics\Service\Admin\Overview\OverviewManager;
use Goyo_Statistics\Service\Admin\PageInsights\PageInsightsManager;
use Goyo_Statistics\Service\Admin\Posts\PostsManager;
use Goyo_Statistics\Service\Admin\PrivacyAudit\PrivacyAuditManager;
use Goyo_Statistics\Service\Admin\HelpCenter\HelpCenterManager;
use Goyo_Statistics\Service\Admin\Referrals\ReferralsManager;
use Goyo_Statistics\Service\Admin\TrackerDebugger\TrackerDebuggerManager;
use Goyo_Statistics\Service\Admin\VisitorInsights\VisitorInsightsManager;
use Goyo_Statistics\Service\Analytics\AnalyticsManager;
use Goyo_Statistics\Service\HooksManager;
use Goyo_Statistics\Service\CronEventManager;
use Goyo_Statistics\Service\Database\Migrations\Queue\QueueManager as DatabaseMigrationQueueManager;
use Goyo_Statistics\Service\Integrations\IntegrationsManager;
use Goyo_Statistics\Service\CustomEvent\CustomEventManager;
use Goyo_Statistics\Service\Admin\ExportImport\ExportImportManager;
use Goyo_Statistics\CLI\CliCommands;
use Goyo_Statistics\Service\Admin\Optimization\OptimizationManager;
use Goyo_Statistics\Globals\AjaxManager;
use Goyo_Statistics\Service\Database\Migrations\BackgroundProcess\BackgroundProcessManager;
use Goyo_Statistics\Service\Summary\SummaryManager;

defined('ABSPATH') || exit;

/**
 * Main bootstrap class for WP Statistics
 *
 * @package WP Statistics
 */
final class Goyo_Statistics
{
    /**
     * The single instance of the class.
     *
     * @var Goyo_Statistics
     */
    protected static $_instance = null;

    /**
     * Main WP Statistics Instance.
     * Ensures only one instance of WP Statistics is loaded or can be loaded.
     *
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Goyo_Statistics constructor.
     */
    public function __construct()
    {
        /**
         * Plugin Loaded Action
         */
        add_action('plugins_loaded', array($this, 'plugin_setup'), 10);

        /**
         * Install And Upgrade plugin
         */
        register_activation_hook(GOYO_STATISTICS_MAIN_FILE, [$this, 'activator']);

        /**
         * Remove plugin data
         */
        register_uninstall_hook(GOYO_STATISTICS_MAIN_FILE, [self::class, 'uninstaller']);

        /**
         * goyo-statistics loaded
         */
        do_action('goyo_statistics_loaded');
    }

    /**
     * Constructors plugin Setup
     *
     * @throws Exception
     */
    public function plugin_setup()
    {
        /**
         * Load text domain
         */
        add_action('init', array($this, 'load_textdomain'));

        try {

            /**
             * Include require file
             */
            $this->includes();

            /**
             * Initialize classes during WordPress initialization.
             */
            add_action('init', function () {
                $postsManager = new PostsManager();
            });
        } catch (Exception $e) {
            self::log($e->getMessage());
        }
    }

    /**
     * Includes plugin files
     */
    public function includes()
    {
        // third-party Libraries
        require_once GOYO_STATISTICS_DIR . 'vendor/autoload.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-helper.php';

        // Create the plugin upload directory in advance.
        $this->create_upload_directory();

        require_once GOYO_STATISTICS_DIR . 'includes/libraries/wp-background-processing/wp-async-request.php';
        require_once GOYO_STATISTICS_DIR . 'includes/libraries/wp-background-processing/wp-background-process.php';

        // Utility classes.
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-db.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-timezone.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-option.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-user.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-mail.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-menus.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-meta-box.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-admin-bar.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-rest-api.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-purge.php';

        // Hits Class
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-country.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-user-online.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-user-agent.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-ip.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-geoip.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-pages.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-visitor.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-historical.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-referred.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-search-engine.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-exclusion.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-hits.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-privacy-exporter.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-privacy-erasers.php';

        // Ajax area
        require_once GOYO_STATISTICS_DIR . 'includes/admin/class-wp-statistics-admin-template.php';

        $referrals                  = new ReferralsManager();
        $userOnline                 = new \GOYO_STATISTICS\UserOnline();
        $anonymizedUsageDataManager = new AnonymizedUsageDataManager();
        $exportImportManager        = new ExportImportManager();

        CoreFactory::updater();

        new BackgroundProcessManager();

        // Admin classes
        if (is_admin()) {
            CoreFactory::loader();

            $adminManager     = new \Goyo_Statistics\Service\Admin\AdminManager();


            require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-install.php';
            require_once GOYO_STATISTICS_DIR . 'includes/admin/class-wp-statistics-admin-ajax.php';
            require_once GOYO_STATISTICS_DIR . 'includes/admin/class-wp-statistics-admin-dashboard.php';
            require_once GOYO_STATISTICS_DIR . 'includes/admin/class-wp-statistics-admin-export.php';

            require_once GOYO_STATISTICS_DIR . 'includes/admin/class-wp-statistics-admin-assets.php';
            require_once GOYO_STATISTICS_DIR . 'includes/admin/class-wp-statistics-admin-user.php';
            require_once GOYO_STATISTICS_DIR . 'includes/admin/class-wp-statistics-admin-privacy.php';

            // Admin Pages List

            $analytics           = new AnalyticsManager();

            $integrationsManager = new IntegrationsManager();

            $metaboxManager      = new MetaboxManager();


            new FilterManager();
            new DatabaseMigrationQueueManager();
        }

        $hooksManager       = new HooksManager();
        $customEventManager = new CustomEventManager();
        $ajaxManager        = new AjaxManager();
        $summaryManager     = new SummaryManager();

        // WordPress ShortCode and Widget



        // Rest-Api
        require_once GOYO_STATISTICS_DIR . 'includes/api/v2/class-wp-statistics-api-hit.php';
        require_once GOYO_STATISTICS_DIR . 'includes/api/v2/class-wp-statistics-api-meta-box.php';

        // WordPress Cron
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-schedule.php';

        // Front Class.
        if (!is_admin()) {
            require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-frontend.php';
        }

        // WP-CLI Class.
        if (defined('WP_CLI') && WP_CLI) {
            \WP_CLI::add_command('goyo_statistics', CliCommands::class);
        }

        // Template functions.
        include GOYO_STATISTICS_DIR . 'includes/template-functions.php';

        // Include functions
        require_once GOYO_STATISTICS_DIR . 'functions.php';
    }

    private function create_upload_directory()
    {
        $upload_dir      = wp_upload_dir();
        $upload_dir_name = $upload_dir['basedir'] . '/' . GOYO_STATISTICS_UPLOADS_DIR;

        $result = wp_mkdir_p($upload_dir_name);

        // Check if the directory creation failed.
        if (!$result) {
            /* translators: %s: string value */
            $errorMessage = sprintf(__('Unable to create the required upload directory at <code>%s</code>. Please check that the web server has write permissions for the parent directory. Alternatively, you can manually create the directory yourself. Please keep in mind that the GeoIP database may not work correctly if the directory structure is not properly set up.', 'goyo-statistics'), esc_html($upload_dir_name));
            Notice::addNotice($errorMessage, 'create_upload_directory', 'warning', false);
        }

        /**
         * Create .htaccess to avoid public access.
         */
        // phpcs:disable
        if (apply_filters('goyo_statistics_enable_htaccess_protection', true) && is_dir($upload_dir_name) && is_writable($upload_dir_name)) {
            $htaccess_file = path_join($upload_dir_name, '.htaccess');

            if (!file_exists($htaccess_file)
                and $handle = @fopen($htaccess_file, 'w')) {
                fwrite($handle, "Deny from all\n");
                fclose($handle);
            }
        }
        // phpcs:enable

    }

    /**
     * Loads the load plugin text domain code.
     */
    public function load_textdomain()
    {
        unload_textdomain('goyo-statistics', true);
        load_textdomain('goyo-statistics', GOYO_STATISTICS_DIR . 'languages/wp-statistics-ko_KR.mo', 'ko_KR');
    }

    /**
     * The main logging function
     *
     * @param string $message The message to be logged.
     * @param string $level The log level (e.g., 'info', 'warning', 'error'). Default is 'info'.
     * @uses error_log
     */
    public static function log($message, $level = 'info')
    {
        if (is_array($message)) {
            $message = wp_json_encode($message);
        }

        $log_level = strtoupper($level);


        // Log when debug is enabled
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log(sprintf('[WP STATISTICS] [%s]: %s', $log_level, $message));
        }
    }

    /**
     * Plugin activation callback.
     *
     * Called by WordPress via register_activation_hook() when the plugin is activated.
     * Defers to CoreFactory::activator() to perform the actual activation tasks.
     *
     * @param bool $networkWide Whether the plugin is being activated network-wide on multisite.
     * @return void
     */
    public function activator($networkWide)
    {
        require_once GOYO_STATISTICS_DIR . 'vendor/autoload.php';
        CoreFactory::activator($networkWide);
    }

    /**
     * Plugin uninstall callback.
     *
     * Called by WordPress via register_uninstall_hook() when the plugin is uninstalled.
     * Performs final cleanup by delegating to CoreFactory::uninstaller().
     *
     * @return void
     */
    public static function uninstaller()
    {
        require_once GOYO_STATISTICS_DIR . 'vendor/autoload.php';
        CoreFactory::uninstaller();
    }
}