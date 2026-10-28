<?php
namespace Goyo_Statistics\Service\Analytics\Referrals;

class SourceChannels
{
    /**
     * Returns the list of source channels.
     *
     * @return array List of source channels.
     */
    public static function getList()
    {
        $channels = [
            'direct'                => esc_html__('Direct Traffic', 'goyo-statistics'),
            'search'                => esc_html__('Organic Search', 'goyo-statistics'),
            'ai_assistants'         => esc_html__('AI Assistants', 'goyo-statistics'),
            'paid_search'           => esc_html__('Paid Search', 'goyo-statistics'),
            'affiliates'            => esc_html__('Affiliates', 'goyo-statistics'),
            'audio'                 => esc_html__('Audio', 'goyo-statistics'),
            'display'               => esc_html__('Display', 'goyo-statistics'),
            'email'                 => esc_html__('Email', 'goyo-statistics'),
            'mobile_notification'   => esc_html__('Mobile Notification', 'goyo-statistics'),
            'shopping'              => esc_html__('Organic Shopping', 'goyo-statistics'),
            'social'                => esc_html__('Organic Social', 'goyo-statistics'),
            'video'                 => esc_html__('Organic Video', 'goyo-statistics'),
            'paid_shopping'         => esc_html__('Paid Shopping', 'goyo-statistics'),
            'paid_social'           => esc_html__('Paid Social', 'goyo-statistics'),
            'paid_video'            => esc_html__('Paid Video', 'goyo-statistics'),
            'paid_other'            => esc_html__('Paid Other', 'goyo-statistics'),
            'referral'              => esc_html__('Referral', 'goyo-statistics'),
            'sms'                   => esc_html__('SMS', 'goyo-statistics'),
            'unassigned'            => esc_html__('Unassigned Traffic', 'goyo-statistics')
        ];

        return apply_filters('goyo_statistics_source_channels_list', $channels);
    }

    /**
     * Returns the name of a source channel based on the given key.
     *
     * @param string $key The key of the source channel.
     * @return string The name of the source channel if found, Unknown otherwise.
     */
    public static function getName($key)
    {
        $channels = self::getList();
        return $channels[$key];
    }
}