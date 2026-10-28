<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Service\Admin\NoticeHandler\Notice;
use Goyo_Statistics\Option;

$installationTime = get_option('goyo_statistics_installation_time');

if (current_user_can('manage_options') && !Option::get('share_anonymous_data') && !in_array('share_anonymous_data', get_option('goyo_statistics_dismissed_notices', [])) && (time() > $installationTime + 7 * DAY_IN_SECONDS)) {
    $notice = [
        'title'   => __('Help Us Improve WP Statistics!', 'goyo-statistics'),
        'content' => __('We’ve added a new Usage Tracking option to help us understand how WP Statistics is used and identify areas for improvement. By enabling this feature, you’ll help us make the plugin better for everyone. No personal or sensitive data is collected.', 'goyo-statistics'),
        'links'   => [
            'learn_more'     => [
                'text' => __('Learn More', 'goyo-statistics'),
                'url'  => 'https://wp-statistics.com/resources/sharing-your-data-with-us/?utm_source=goyo-statistics&utm_medium=link&utm_campaign=doc',
            ],
            'primary_button' => [
                'text'       => __('Enable Share Anonymous Data', 'goyo-statistics'),
                'url'        => '#',
                'attributes' => [
                    'data-option' => 'share_anonymous_data',
                    'data-value'  => 'true',
                ],
                'class'      => 'goyostats-option__updater notice--enable-usage',
            ]
        ]
    ];
    Notice::renderNotice($notice, 'share_anonymous_data', 'setting', true, 'action');
}
?>
