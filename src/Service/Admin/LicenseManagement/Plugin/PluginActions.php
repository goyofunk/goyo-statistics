<?php

namespace Goyo_Statistics\Service\Admin\LicenseManagement\Plugin;

use Exception;
use Goyo_Statistics\Utils\Request;
use Goyo_Statistics\Service\Admin\LicenseManagement\ApiCommunicator;
use Goyo_Statistics\Service\Admin\LicenseManagement\LicenseHelper;
use Goyo_Statistics\Service\Admin\LicenseManagement\Plugin\PluginHandler;
use GOYO_STATISTICS\User;

/**
 * @todo Register ajax using Ajax::register() and send response in a standard format using Ajax::success() or Ajax::error()
 */
class PluginActions
{
    private $apiCommunicator;
    private $pluginHandler;

    public function __construct()
    {
        $this->apiCommunicator = new ApiCommunicator();
        $this->pluginHandler   = new PluginHandler();
    }

    public function registerAjaxCallbacks($list)
    {
        $list[] = [
            'class'  => $this,
            'action' => 'check_license'
        ];
        $list[] = [
            'class'  => $this,
            'action' => 'download_plugin'
        ];
        $list[] = [
            'class'  => $this,
            'action' => 'check_plugin'
        ];
        $list[] = [
            'class'  => $this,
            'action' => 'activate_plugin'
        ];

        return $list;
    }

    public function check_license_action_callback()
    {
        check_ajax_referer('wp_rest', 'goyostats_nonce');

        try {
            if (!User::Access('manage')) {
                throw new Exception(esc_html__('Unauthorized access.', 'goyo-statistics'));
            }

            $licenseKey = Request::has('license_key') ? wp_unslash(Request::get('license_key')) : false;
            $addOn      = Request::get('addon_slug');

            if (!$licenseKey) {
                throw new Exception(__('License key is missing.', 'goyo-statistics'));
            }

            $this->apiCommunicator->validateLicense($licenseKey, $addOn);

            wp_send_json_success([
                'message' => __('You\'re All Set! Your License is Successfully Activated!', 'goyo-statistics'),
            ]);
        } catch (Exception $e) {
            wp_send_json_error([
                'message' => $e->getMessage(),
            ]);
        }

        exit;
    }

    public function download_plugin_action_callback()
    {
        check_ajax_referer('wp_rest', 'goyostats_nonce');

        try {
            if (!User::Access('manage')) {
                throw new Exception(esc_html__('Unauthorized access.', 'goyo-statistics'));
            }

            $licenseKey = Request::has('license_key') ? wp_unslash(Request::get('license_key')) : false;
            $pluginSlug = Request::has('plugin_slug') ? wp_unslash(Request::get('plugin_slug')) : false;

            if (!is_main_site()) {
                throw new Exception(__('Plugin installation is not permitted on this sub-site. Please contact your network administrator to install the plugin across the entire network.', 'goyo-statistics'));
            }

            if (!$pluginSlug) {
                throw new Exception(__('Plugin slug is missing.', 'goyo-statistics'));
            }

            if (empty($licenseKey)) {
                $licenseKey = LicenseHelper::getPluginLicense($pluginSlug);
            }

            if (empty($licenseKey)) {
                throw new Exception(__('License key is missing.', 'goyo-statistics'));
            }

            $downloadUrl = $this->apiCommunicator->getDownloadUrlFromLicense($licenseKey, $pluginSlug);
            if (!$downloadUrl) {
                throw new Exception(__('Download URL not found!', 'goyo-statistics'));
            }

            // Download and install the plugin
            $this->pluginHandler->downloadAndInstallPlugin($downloadUrl);

            wp_send_json_success([
                'message' => __('Plugin downloaded and installed successfully.', 'goyo-statistics'),
            ]);
        } catch (Exception $e) {
            wp_send_json_error([
                'message' => $e->getMessage(),
            ]);
        }

        exit;
    }

    /**
     * Handles `check_plugin` ajax call and returns info about a local plugin.
     *
     * @return void
     */
    public function check_plugin_action_callback()
    {
        check_ajax_referer('wp_rest', 'goyostats_nonce');

        try {
            if (!User::Access('manage')) {
                throw new Exception(esc_html__('Unauthorized access.', 'goyo-statistics'));
            }

            $pluginSlug = Request::has('plugin_slug') ? wp_unslash(Request::get('plugin_slug')) : false;
            if (!$pluginSlug) {
                throw new Exception(__('Plugin slug is missing.', 'goyo-statistics'));
            }

            wp_send_json_success([
                'active' => $this->pluginHandler->isPluginActive($pluginSlug),
                'data'   => $this->pluginHandler->getPluginData($pluginSlug),
            ]);
        } catch (Exception $e) {
            wp_send_json_error([
                'message' => $e->getMessage(),
            ]);
        }

        exit;
    }

    public function activate_plugin_action_callback()
    {
        check_ajax_referer('wp_rest', 'goyostats_nonce');

        try {
            if (!User::Access('manage')) {
                throw new Exception(esc_html__('Unauthorized access.', 'goyo-statistics'));
            }

            $pluginSlug = Request::has('plugin_slug') ? wp_unslash(Request::get('plugin_slug')) : false;

            if (!$pluginSlug) {
                throw new Exception(__('Plugin slug is missing.', 'goyo-statistics'));
            }

            $this->pluginHandler->activatePlugin($pluginSlug);

            wp_send_json_success([
                'message' => __('Plugin activated successfully.', 'goyo-statistics'),
            ]);
        } catch (Exception $e) {
            wp_send_json_error([
                'message' => $e->getMessage(),
            ]);
        }

        exit;
    }
}