<?php
namespace Goyo_Statistics\Service\CustomEvent;

use Exception;
use Goyo_Statistics\Models\EventsModel;
use Goyo_Statistics\Utils\Request;
use Goyo_Statistics\Components\Ajax;
use Goyo_Statistics\Components\TrackingResponse;
use GOYO_STATISTICS\Exclusion;
use Goyo_Statistics\Service\Analytics\VisitorProfile;

/**
 * @todo Send responses in a standard format using Ajax::success() or Ajax::error()
 */
class CustomEventActions
{
    public function register()
    {
        Ajax::register('custom_event', [$this, 'insertCustomEvent']);
    }

    public function insertCustomEvent()
    {
        TrackingResponse::sendHeaders();

        try {
            $nonce = Request::get('nonce');

            if (!wp_verify_nonce($nonce, 'goyo_statistics_custom_event')) {
                throw new Exception(esc_html__('Access denied.', 'goyo-statistics'));
            }

            $GLOBALS['goyo_statistics_user_id'] = get_current_user_id();

            $visitorProfile = new VisitorProfile();

            $exclusion = Exclusion::check($visitorProfile);
            if ($exclusion['exclusion_match'] === true) {
                Exclusion::record($exclusion);

                throw new Exception($exclusion['exclusion_reason']);
            }

            $eventName = Request::get('event_name');
            $eventData = Request::get('event_data');

            // Decode the json event data
            $eventData = json_decode(stripslashes($eventData), true);

            // Parse event data
            $eventDataParser = new CustomEventDataParser($eventName, $eventData, $visitorProfile);
            $parsedData      = $eventDataParser->getParsedData();

            // Insert event into the database
            $eventsModel = new EventsModel();
            $eventsModel->insertEvent($parsedData);

            wp_send_json_success(['message' => esc_html__('Event recorded successfully.', 'goyo-statistics')], 200);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()], 200);
        }

        exit;
    }
}