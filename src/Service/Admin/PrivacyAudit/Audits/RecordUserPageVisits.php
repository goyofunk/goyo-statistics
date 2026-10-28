<?php

namespace Goyo_Statistics\Service\Admin\PrivacyAudit\Audits;

use Goyo_Statistics\Components\View;
use Goyo_Statistics\Service\Admin\PrivacyAudit\Audits\Abstracts\ResolvableAudit;

class RecordUserPageVisits extends ResolvableAudit
{
    public static $optionKey = 'visitors_log';

    public static function isOptionPassed()
    {
        // If option is disabled, consider it passed.
        return !self::isOptionEnabled();
    }

    public static function getPassedStateInfo()
    {
        return [
            'title' => esc_html__('The “Track Logged-In User Activity” feature is currently disabled on your website.', 'goyo-statistics'),
            'notes' => View::load('components/privacy-audit/visitors-log', [], true),
        ];
    }

    public static function getUnpassedStateInfo()
    {
        return [
            'title' => esc_html__('The “Track Logged-In User Activity” feature is currently enabled on your website.', 'goyo-statistics'),
            'notes' => View::load('components/privacy-audit/visitors-log-unpassed', [], true),
        ];
    }
}