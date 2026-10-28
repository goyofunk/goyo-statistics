<?php

namespace Goyo_Statistics\Service\Analytics\DeviceDetection;

class DeviceHelper
{
    /**
     * Get all browser list for detection.
     *
     * @param bool|string $all
     * @return array|string
     */
    public static function getBrowserList($all = true)
    {
        $list = [
            'aloha_browser'     => __('Aloha Browser', 'goyo-statistics'),
            'brave'             => __('Brave', 'goyo-statistics'),
            'chrome'            => __('Chrome', 'goyo-statistics'),
            'duckduckgo'        => __('DuckDuckGo', 'goyo-statistics'),
            'microsoft_edge'    => __('Edge', 'goyo-statistics'),
            'firefox'           => __('Firefox', 'goyo-statistics'),
            'internet_explorer' => __('Internet Explorer', 'goyo-statistics'),
            'opera'             => __('Opera', 'goyo-statistics'),
            'safari'            => __('Safari', 'goyo-statistics'),
            'samsung_browser'   => __('Samsung Browser', 'goyo-statistics'),
            'uc_browser'        => __('UC Browser', 'goyo-statistics'),
            'waterfox'          => __('Waterfox', 'goyo-statistics'),
            'yandex_browser'    => __('Yandex Browser', 'goyo-statistics'),
            'whale_browser'     => __('Whale Browser', 'goyo-statistics')
        ];

        if ($all === true) {
            return $list;
        } elseif ($all === 'key') {
            return array_keys($list);
        }

        $browser = strtolower(str_replace(' ', '_', $all));

        return $list[$browser] ?? __('Unknown', 'goyo-statistics');
    }

    /**
     * Returns browser logo URL.
     *
     * @param string $browser
     * @return string
     */
    public static function getBrowserLogo(string $browser)
    {
        $browser  = str_replace(' ', '_', strtolower($browser));
        $logoPath = "assets/images/browser/{$browser}.svg";

        if (file_exists(GOYO_STATISTICS_DIR . $logoPath)) {
            return esc_url(GOYO_STATISTICS_URL . $logoPath);
        }

        return esc_url(GOYO_STATISTICS_URL . 'assets/images/browser/unknown.svg');
    }

    /**
     * Returns platform/OS logo URL.
     *
     * @param string $platform
     * @return string
     */
    public static function getPlatformLogo(string $platform)
    {
        $platform = str_replace([' ', '/'], '_', sanitize_text_field(strtolower($platform)));
        $logoPath = "assets/images/operating-system/{$platform}.svg";

        if (file_exists(GOYO_STATISTICS_DIR . $logoPath)) {
            return esc_url(GOYO_STATISTICS_URL . $logoPath);
        }

        return esc_url(GOYO_STATISTICS_URL . 'assets/images/operating-system/unknown.svg');
    }

    /**
     * Returns device logo URL.
     *
     * @param string $device
     * @return string
     */
    public static function getDeviceLogo($device)
    {
        $device = str_replace([' ', '/'], '_', sanitize_text_field(strtolower($device)));
        $logoPath = "assets/images/device/{$device}.svg";

        if (file_exists(GOYO_STATISTICS_DIR . $logoPath)) {
            return esc_url(GOYO_STATISTICS_URL . $logoPath);
        }

        return esc_url(GOYO_STATISTICS_URL . 'assets/images/device/unknown.svg');
    }
}
