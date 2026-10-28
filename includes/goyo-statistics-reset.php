<?php
/** Explicit, administrator-only reset of Goyo's collected statistics. */
defined('ABSPATH') || exit;

function goyo_statistics_reset_collected_data()
{
    global $wpdb;
    $tables = [];
    foreach (['visitor_relationships', 'events', 'pages', 'visitor', 'exclusions', 'historical', 'summary_totals'] as $name) {
        // Construct only Goyo table names; never accept a table name from a request.
        $table = $wpdb->prefix . 'goyo_statistics_' . $name;
        $status = $wpdb->get_row($wpdb->prepare('SHOW TABLE STATUS WHERE Name = %s', $table));
        if (!$status || strcasecmp($status->Engine, 'InnoDB') !== 0) {
            return new WP_Error('goyo_reset_engine', '통계 테이블을 확인하지 못해 초기화를 중단했습니다. 기존 데이터는 유지됩니다.');
        }
        $tables[] = $table;
    }

    if ($wpdb->query('START TRANSACTION') === false) {
        return new WP_Error('goyo_reset_transaction', '초기화를 시작하지 못했습니다.');
    }
    foreach ($tables as $table) {
        if ($wpdb->query('DELETE FROM `' . str_replace('`', '``', $table) . '`') === false) {
            $wpdb->query('ROLLBACK');
            return new WP_Error('goyo_reset_failed', '초기화에 실패하여 삭제 작업을 취소했습니다.');
        }
    }
    if ($wpdb->query('COMMIT') === false) {
        $wpdb->query('ROLLBACK');
        return new WP_Error('goyo_reset_commit', '초기화 결과를 저장하지 못했습니다.');
    }

    // Invalidate only Goyo caches, including persistent object-cache backends.
    update_option('goyo_statistics_cache_generation', wp_generate_uuid4(), false);
    return true;
}

add_action('admin_post_goyo_statistics_reset', function () {
    if (!current_user_can('manage_options')) {
        wp_die('통계를 초기화할 권한이 없습니다.', '통계초기화', ['response' => 403]);
    }
    check_admin_referer('goyo_statistics_reset');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST['goyo_statistics_confirm_reset']) || $_POST['goyo_statistics_confirm_reset'] !== 'yes') {
            wp_die('초기화 확인이 필요합니다.', '통계초기화', ['response' => 400]);
        }
        $result = goyo_statistics_reset_collected_data();
        if (is_wp_error($result)) {
            wp_die(esc_html($result->get_error_message()), '통계초기화', ['response' => 500, 'back_link' => true]);
        }
        wp_safe_redirect(admin_url('index.php?goyo_statistics_reset=done'));
        exit;
    }

    ob_start();
    ?>
    <h1>고요통계 초기화</h1>
    <p>고요통계의 방문자, 조회수, 인기페이지, 도시별 통계와 누적 기록을 모두 삭제합니다. 삭제한 기록은 되돌릴 수 없습니다.</p>
    <p>WP Statistics 데이터와 고요통계 설정은 유지됩니다. 초기화 후 발생하는 방문부터 새로 집계합니다.</p>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="goyo_statistics_reset">
        <?php wp_nonce_field('goyo_statistics_reset'); ?>
        <p><label><input type="checkbox" name="goyo_statistics_confirm_reset" value="yes" required> 고요통계 기록을 모두 삭제하는 데 동의합니다.</label></p>
        <p><button type="submit" class="button">통계초기화 실행</button> <a href="<?php echo esc_url(admin_url('index.php')); ?>">취소</a></p>
    </form>
    <?php
    wp_die(ob_get_clean(), '고요통계 초기화', ['response' => 200]);
});

add_action('admin_notices', function () {
    if (current_user_can('manage_options') && isset($_GET['goyo_statistics_reset']) && $_GET['goyo_statistics_reset'] === 'done') {
        echo '<div class="notice notice-success is-dismissible"><p>고요통계 기록을 초기화했습니다. 새로운 방문부터 집계합니다.</p></div>';
    }
});
