<?php

namespace Goyo_Statistics\Service\Admin\PrivacyAudit\Audits;

use Goyo_Statistics\Components\View;
use Goyo_Statistics\Service\Admin\PrivacyAudit\Audits\Abstracts\ResolvableAudit;

class HashIpAddress extends ResolvableAudit
{
    public static $optionKey = 'hash_ips';

    public static function getPassedStateInfo()
    {
        return [
            'title' => esc_html__('The “Hash IP Addresses” feature is currently enabled on your website.', 'goyo-statistics'),
            'notes' => View::load('components/privacy-audit/hash-ips', [], true),
        ];
    }

    public static function getUnpassedStateInfo()
    {
        return [
            'title'      => esc_html__('The “Hash IP Addresses” feature is currently disabled on your website.', 'goyo-statistics'),
            'notes' => View::load('components/privacy-audit/hash-ips-unpassed', [], true),
        ];
    }
}