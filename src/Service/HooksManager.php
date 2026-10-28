<?php

namespace Goyo_Statistics\Service;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Exception;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Components\AssetNameObfuscator;
use Goyo_Statistics\Globals\Context;
use Goyo_Statistics\Service\Admin\LicenseManagement\LicenseHelper;

class HooksManager
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'setWpsPage']);
        add_filter('kses_allowed_protocols', [$this, 'updateAllowedProtocols']);
        add_filter('plugin_action_links_' . plugin_basename(GOYO_STATISTICS_MAIN_FILE), [$this, 'addActionLinks']);
        add_filter('plugins_loaded', [$this, 'serveObfuscatedAsset'], PHP_INT_MAX);
    }

    /**
     * Sets the current page, view and tab in the context.
     *
     * @return void
     */
    public function setWpsPage()
    {
        $wpsPage = ['slug' => null, 'view' => null, 'tab' => null];

        $page      = Menus::getCurrentPage();
        $className = $page['callback'] ?? '';

        if (class_exists($className)) {
            $class = $className::instance();

            if (method_exists($class, 'getPageSlug')) {
                $wpsPage['slug'] = $class->getPageSlug();
            }

            if (method_exists($class, 'getCurrentView')) {
                $wpsPage['view'] = $class->getCurrentView();
            }

            if (method_exists($class, 'getCurrentViewClass')) {
                try {
                    $view = $class->getCurrentViewClass();

                    if (method_exists($view, 'getCurrentTab')) {
                        $wpsPage['tab'] = $view->getCurrentTab();
                    }
                } catch (Exception $e) {
                    // View is built only to populate page context; never let its constructor fatal the admin.
                    \Goyo_Statistics::log($e->getMessage(), 'error');
                }
            }

            Context::add('goyostats_page', $wpsPage);
        }
    }

    /**
     * Adds custom links to the plugin action links in the WordPress admin plugins page.
     *
     * @param array $links The existing plugin action links.
     *
     * @return array The modified links with the custom links added.
     */
    public function addActionLinks($links)
    {
        return $links;
    }

    /**
     * Modifies the list of allowed protocols.
     *
     * @param array $protocols The list of allowed protocols.
     */
    public function updateAllowedProtocols($defaultProtocols)
    {
        $customProtocols = [
            'android-app'
        ];

        $customProtocols = apply_filters('goyo_statistics_allowed_protocols', $customProtocols);

        return array_merge($defaultProtocols, $customProtocols);
    }

    /**
     * Proxies requested asset files through PHP to serve them securely.
     *
     * @return void
     */
    public function serveObfuscatedAsset()
    {
        $assetNameObfuscator = new AssetNameObfuscator();
        $dynamicAssetKey     = $assetNameObfuscator->getDynamicAssetKey();

        if (isset($_GET[$dynamicAssetKey]) && is_string($_GET[$dynamicAssetKey])) {
            $asset   = sanitize_text_field(wp_unslash($_GET[$dynamicAssetKey]));
            $version = isset($_GET['ver']) && is_string($_GET['ver']) ? sanitize_text_field(wp_unslash($_GET['ver'])) : '';
            $assetNameObfuscator->serveAssetByHash($asset, $version);
        }
    }
}
