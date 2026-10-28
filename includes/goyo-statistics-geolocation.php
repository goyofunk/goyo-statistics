<?php
/** Prepare the independent city database without delaying page requests. */
defined('ABSPATH') || exit;

function goyo_statistics_geoip_ready()
{
    $uploads = wp_upload_dir();
    return is_file($uploads['basedir'] . '/' . GOYO_STATISTICS_UPLOADS_DIR . '/GeoLite2-City.mmdb');
}

function goyo_statistics_schedule_geoip()
{
    if (!class_exists('GOYO_STATISTICS\Option')
        || !\GOYO_STATISTICS\Option::get('geoip')
        || \GOYO_STATISTICS\Option::get('geoip_location_detection_method', 'maxmind') !== 'maxmind'
        || \Goyo_Statistics\Utils\Env::isLocal()
        || goyo_statistics_geoip_ready()) {
        return;
    }
    $hook = 'goyo_statistics_prepare_city_database';
    if (!wp_next_scheduled($hook)) {
        $retry = (int) get_option('goyo_statistics_geoip_retry_after', 0);
        wp_schedule_single_event(max(time() + 10, $retry), $hook);
    }
}

function goyo_statistics_prepare_city_database()
{
    if (goyo_statistics_geoip_ready()
        || \Goyo_Statistics\Utils\Env::isLocal()
        || !\GOYO_STATISTICS\Option::get('geoip')
        || \GOYO_STATISTICS\Option::get('geoip_location_detection_method', 'maxmind') !== 'maxmind') {
        return;
    }
    // Atomic option lock prevents concurrent requests from replacing the same file.
    $lock = (int) get_option('goyo_statistics_geoip_download_lock', 0);
    if ($lock && $lock > time() - 600) {
        return;
    }
    if ($lock) {
        delete_option('goyo_statistics_geoip_download_lock');
    }
    if (!add_option('goyo_statistics_geoip_download_lock', time(), '', false)) {
        return;
    }
    try {
        update_option('goyo_statistics_geoip_retry_after', time() + HOUR_IN_SECONDS, false);
        $result = \Goyo_Statistics\Service\Geolocation\GeolocationFactory::downloadDatabase();
        if (is_wp_error($result)) {
            update_option('goyo_statistics_geoip_download_error', $result->get_error_message(), false);
        } else {
            delete_option('goyo_statistics_geoip_download_error');
            delete_option('goyo_statistics_geoip_retry_after');
        }
    } catch (\Throwable $error) {
        update_option('goyo_statistics_geoip_download_error', $error->getMessage(), false);
    } finally {
        delete_option('goyo_statistics_geoip_download_lock');
        goyo_statistics_schedule_geoip();
    }
}

function goyo_statistics_geoip_message()
{
    if (\Goyo_Statistics\Utils\Env::isLocal()) {
        return '로컬 환경에서는 도시 위치를 수집하지 않습니다. 실제 서버의 외부 방문부터 집계됩니다.';
    }
    if (\GOYO_STATISTICS\Option::get('geoip_location_detection_method', 'maxmind') !== 'maxmind'
        || goyo_statistics_geoip_ready()) {
        return '';
    }
    if (get_option('goyo_statistics_geoip_download_error')) {
        return '도시 데이터베이스를 내려받지 못했습니다. 자동으로 재시도합니다. 서버의 외부 HTTPS 연결과 업로드 폴더 쓰기 권한을 확인해주세요.';
    }
    return '도시 데이터베이스를 준비하고 있습니다. 준비가 끝난 뒤 수집된 방문부터 표시됩니다.';
}

add_action('init', 'goyo_statistics_schedule_geoip', 20);
add_action('goyo_statistics_prepare_city_database', 'goyo_statistics_prepare_city_database');
