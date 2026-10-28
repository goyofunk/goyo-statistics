<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Utils\Request;

$order = Request::get('order', 'desc');
?>

    <div class="inside">
        <?php if (!empty($data['data'])) : ?>
            <div class="o-table-wrapper">
                <table width="100%" class="o-table goyostats-new-table goyostats-new-table--404">
                    <thead>
                    <tr>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('URL', 'goyo-statistics'); ?>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <a href="<?php echo esc_url(Helper::getTableColumnSortUrl('views')); ?>" class="sort <?php echo esc_attr($order); ?>">
                                <?php esc_html_e('Views', 'goyo-statistics') ?>
                            </a>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($data['data'] as $item) : ?>
                        <tr>
                            <td class="goyostats-pd-l">
                                <a href="<?php echo esc_url(Menus::admin_url('content-analytics', ['type' => 'single-resource', 'uri' => urlencode($item->uri)])) ?>"><?php echo esc_html($item->uri) ?></a>
                            </td>

                            <td class="goyostats-pd-l"><?php echo esc_html($item->views) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="o-wrap o-wrap--no-data goyostats-center">
                <?php esc_html_e('No recent data available.', 'goyo-statistics') ?>
            </div>
        <?php endif; ?>
    </div>
<?php
echo isset($pagination) ? $pagination : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
?>