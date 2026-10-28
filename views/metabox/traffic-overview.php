<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Menus;
use GOYO_STATISTICS\Option;
use Goyo_Statistics\Components\View;
use GOYO_STATISTICS\Helper;

$chartData = $data['summary']['7days']['data'];
?>

<div class="goyostats-meta-traffic-summary">

    <div class="o-wrap">
        <div class="goyostats-postbox-chart--title">
            <span class="goyostats-chart--title"><?php esc_html_e('Last 7 days (exclude today)', 'goyo-statistics'); ?></span>
            <div class="goyostats-postbox-chart--info">
                <div class="goyostats-postbox-chart--previousPeriod">
                    <?php esc_html_e('Previous period', 'goyo-statistics') ?>
                </div>
            </div>
        </div>

        <div class="goyostats-postbox-chart--data">
            <div class="goyostats-postbox-chart--items"></div>
            <div class="goyostats-postbox-chart--items">
                <div class="goyostats-postbox-chart--item__data">
                    <div class="goyostats-postbox-chart--item">
                        <span><span class="goyostats-postbox-chart--item--color"></span><?php esc_html_e('Visitors', 'goyo-statistics'); ?></span>
                        <div>
                            <div class="current-data">
                                <span><?php echo esc_html(Helper::formatNumberWithUnit($chartData['current']['visitors'], 1)) ?></span>
                                <?php if (isset($chartData['trend']['visitors']['percentage']) && $chartData['trend']['visitors']['percentage'] !== null) : ?>
                                <span class="current-data-percent diffs__change <?php echo esc_attr($chartData['trend']['visitors']['direction']); ?>">
                                    <span class="diffs__change__direction">
                                        <?php echo esc_html($chartData['trend']['visitors']['percentage']) ?>%
                                    </span>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="goyostats-postbox-chart--item">
                        <span><span class="goyostats-postbox-chart--item--color"></span><?php esc_html_e('Views', 'goyo-statistics'); ?></span>
                        <div>
                            <div class="current-data">
                                <span><?php echo esc_html(Helper::formatNumberWithUnit($chartData['current']['views'], 1)) ?></span>
                                <?php if (isset($chartData['trend']['views']['percentage']) && $chartData['trend']['views']['percentage'] !== null) : ?>
                                <span class="current-data-percent diffs__change <?php echo esc_attr($chartData['trend']['views']['direction']); ?>">
                                    <span class="diffs__change__direction">
                                        <?php echo esc_html($chartData['trend']['views']['percentage']) ?>%
                                    </span>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="goyostats-postbox-chart--container">
            <p id="goyo-statistics-quickstats-widget-chart-title" class="screen-reader-text">
                <?php echo esc_html__('Traffic overview chart', 'goyo-statistics') ?>
            </p>
            <canvas id="goyo-statistics-quickstats-widget-chart" aria-labelledby="goyo-statistics-quickstats-widget-chart-title" role="img" height="166"></canvas>
        </div>
    </div>

    <div class="o-table-wrapper">
        <table width="100%" class="o-table o-table--goyostats-summary-stats">
            <thead>
            <tr>
                <th width="50%" scope="col" style="padding: 6px 12px !important;">
                    <span class="screen-reader-text"><?php esc_html_e('Date range', 'goyo-statistics'); ?></span>
                </th>
                <th scope="col" style="padding: 6px 12px !important;"><?php esc_html_e('Visitors', 'goyo-statistics'); ?></th>
                <th scope="col" style="padding: 6px 12px !important;"><?php esc_html_e('Views', 'goyo-statistics'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($data['summary'] as $key => $item) :
                $itemData = $item['data'];
                ?>
                <tr>
                    <td>
                        <?php echo esc_html($item['label']); ?>

                        <?php if (isset($item['tooltip'])) : ?>
                            <span class="goyostats-tooltip" title="<?php echo esc_attr($item['tooltip']); ?>"><i class="goyostats-tooltip-icon info"></i></span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <div>
                            <span class="quickstats-values" title="<?php echo esc_attr($itemData['current']['visitors']); ?>"><?php echo esc_html(Helper::formatNumberWithUnit($itemData['current']['visitors'], 1)) ?></span>

                            <?php if (!empty($item['comparison']) && isset($itemData['trend']['visitors']['percentage']) && $itemData['trend']['visitors']['percentage'] !== null) : ?>
                                <div class="diffs__change <?php echo esc_attr($itemData['trend']['visitors']['direction']); ?>">
                                    <span class="diffs__change__direction"><?php echo esc_html($itemData['trend']['visitors']['percentage']) ?>%</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </td>

                    <td>
                        <div>
                            <span class="quickstats-values" title="<?php echo esc_attr($itemData['current']['views']); ?>"><?php echo esc_html(Helper::formatNumberWithUnit($itemData['current']['views'], 1)) ?></span>

                            <?php if (!empty($item['comparison']) && isset($itemData['trend']['views']['percentage']) && $itemData['trend']['views']['percentage'] !== null) : ?>
                                <div class="diffs__change <?php echo esc_attr($itemData['trend']['views']['direction']); ?>">
                                    <span class="diffs__change__direction"><?php echo esc_html($itemData['trend']['views']['percentage']) ?>%</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php
    if (!Option::get('time_report') && !in_array('enable_email_metabox_notice', get_option('goyo_statistics_dismissed_notices', []))) {
        View::load("components/meta-box/enable-mail");
    }
    ?>
</div>
<div class="goyo-statistics-dashboard-footer">
    <?php if (current_user_can('manage_options')) : ?>
        <a class="button button-small" href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=goyo_statistics_reset'), 'goyo_statistics_reset')); ?>">통계초기화</a>
    <?php endif; ?>
    <p class="goyo-statistics-donate-note">WP Statistics 코드를 차용하였으며, 무료로 이 기능을 제공해준 개발자에게 후원 링크(Donate link)는 다음과 같습니다. <a href="https://wp-statistics.com/donate/" target="_blank" rel="noopener noreferrer">https://wp-statistics.com/donate/</a></p>
</div>
