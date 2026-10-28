<?php

namespace Goyo_Statistics\Service\Admin\LicenseManagement;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Exception;
use Goyo_Statistics;
use Goyo_Statistics\Exception\LicenseException;
use GOYO_STATISTICS\Option;
use Goyo_Statistics\Service\Admin\LicenseManagement\Plugin\PluginActions;
use Goyo_Statistics\Service\Admin\LicenseManagement\Plugin\PluginHandler;
use Goyo_Statistics\Service\Admin\LicenseManagement\Plugin\PluginUpdater;
use Goyo_Statistics\Service\Admin\NoticeHandler\Notice;
use GOYO_STATISTICS\User;

/**
 * LicenseManagementManager Class
 *
 * Manages the activation and validation of licenses for WP Statistics add-ons.
 * Provides methods to handle license keys and ensure proper functionality of premium features.
 *
 * @package   LicenseManagement
 * @version   1.0.1
 * @since     14.0
 * @author    Foad
 */
class LicenseManagementManager
{
    /** @var ApiCommunicator */
    private $apiCommunicator;

    private $pluginHandler;
    private $handledPlugins = [];

    public function __construct()
    {
        $this->apiCommunicator = new ApiCommunicator();
        $this->pluginHandler   = new PluginHandler();

        // Initialize the necessary components.
        $this->initActionCallbacks();

        add_action('init', [$this, 'initPluginUpdaters']);
        add_action('admin_init', [$this, 'showPluginActivationNotice']);
        add_filter('goyo_statistics_enable_upgrade_to_bundle', [$this, 'showUpgradeToBundle']);
        add_filter('goyo_statistics_admin_menu_list', [$this, 'addMenuItem']);
    }

    public function addMenuItem($items)
    {
        $items['plugins'] = [
            'sub'      => 'overview',
            'title'    => __('Add-ons', 'goyo-statistics'),
            'name'     => '<span class="goyostats-text-warning">' . __('Add-ons', 'goyo-statistics') . '</span>',
            'page_url' => 'plugins',
            'callback' => LicenseManagerPage::class,
            'cap'      => User::ExistCapability(Option::get('manage_capability', 'manage_options')),
            'priority' => 90
        ];
        return $items;
    }

    /**
     * Initialize AJAX callbacks for various license management actions.
     */
    private function initActionCallbacks()
    {
        add_filter('goyo_statistics_ajax_list', [new PluginActions(), 'registerAjaxCallbacks']);
    }

    /**
     * Initialize the PluginUpdater for all stored licenses.
     */
    public function initPluginUpdaters()
    {
        $storedLicenses = LicenseHelper::getLicenses();

        if (empty($storedLicenses)) return;

        foreach ($storedLicenses as $licenseKey => $licenseData) {
            foreach ($licenseData['products'] as $productSlug) {
                // Avoid duplicate handling for the same product
                if (!in_array($productSlug, $this->handledPlugins)) {
                    $this->initPluginUpdaterIfValid($productSlug, $licenseKey);
                }
            }
        }
    }

    /**
     * Initialize PluginUpdater for a specific product and license key.
     *
     * @param string $pluginSlug The slug of the plugin (e.g., 'goyo-statistics-data-plus').
     * @param string $licenseKey The license key for the product.
     */
    private function initPluginUpdaterIfValid($pluginSlug, $licenseKey)
    {
        try {
            if (!$this->pluginHandler->isPluginActive($pluginSlug)) {
                return;
            }

            // Get the dynamic version of the plugin
            $pluginData = $this->pluginHandler->getPluginData($pluginSlug);
            if (!$pluginData) {
                /* translators: %s: string value */
                throw new Exception(sprintf(__('Plugin data not found for: %s', 'goyo-statistics'), $pluginSlug));
            }

            // Initialize PluginUpdater with the version and license key
            $pluginUpdater = new PluginUpdater($pluginSlug, $pluginData['Version'], $licenseKey);
            $pluginUpdater->handle();

            $this->handledPlugins[] = $pluginSlug;

        } catch (Exception $e) {
            Goyo_Statistics::log(sprintf('Failed to initialize PluginUpdater for %s: %s', $pluginSlug, $e->getMessage()));
        }
    }

    /**
     * Loop through plugins and show license notice for those without a valid license
     */
    public function showPluginActivationNotice()
    {
        global $pagenow;

        $plugins = $this->pluginHandler->getInstalledPlugins();

        // Return early on the plugins page, or if the plugins array is empty
        if (empty($plugins) || $pagenow != 'plugins.php') {
            return;
        }

        foreach ($plugins as $plugin) {
            if (!LicenseHelper::isPluginLicenseValid($plugin['TextDomain'])) {
                $pluginUpdater = new PluginUpdater($plugin['TextDomain'], $plugin['Version']);
                $pluginUpdater->handleLicenseNotice();
            }
        }

        // Force a check for updates (prevents showing update notice for plugins without a valid license)
        delete_site_transient('update_plugins');
    }

    /**
     * Show the "Upgrade To Premium" only if the user has a premium license.
     *
     * @return bool
     */
    public function showUpgradeToBundle()
    {
        return LicenseHelper::isPremiumLicenseAvailable() ? false : true;
    }
}
