<?php

namespace Goyo_Statistics\Service\Admin;

use Goyo_Statistics\Components\Ajax;
use Goyo_Statistics\Utils\Request;
use GOYO_STATISTICS\Option;
use Exception;
use GOYO_STATISTICS\User;

/**
 * @todo Send responses in a standard format using Ajax::success() or Ajax::error()
 */
class AjaxOptionUpdater
{
    /**
     * Initializes registering the AJAX handler for the admin area.
     *
     * @return void
     */
    public function init()
    {
        if (!is_admin()) {
            return;
        }

        Ajax::register('option_updater', [$this, 'optionUpdater']);
    }

    /**
     * Handles the AJAX request for updating a specified option in the system.
     *
     * @return void JSON response will be sent with either success or error message.
     * @throws Exception If the nonce is invalid, the option is missing, or any other error occurs.
     *
     */
    public function optionUpdater()
    {
        try {
            if (Request::isFrom('ajax') && User::Access('manage')) {
                check_ajax_referer('wp_rest', 'goyostats_nonce');

                $option = Request::get('option');
                $value  = Request::get('value');

                if ($value === 'true') {
                    $value = true;
                } elseif ($value === 'false') {
                    $value = false;
                }

                Option::update($option, $value);

                wp_send_json_success(['message' => __('Update option success.', 'goyo-statistics')]);
            }
        } catch (Exception $e) {
            wp_send_json_error($e->getMessage());
        }

        exit();
    }
}