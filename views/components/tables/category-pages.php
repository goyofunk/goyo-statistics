<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Menus;
use GOYO_STATISTICS\Helper;
use Goyo_Statistics\Utils\Request;

$order    = Request::get('order', 'desc');
$taxName  = Helper::getTaxonomyName(Request::get('tx', 'category'), true);
?>
<div class="inside">
    <?php if (!empty($data)) : ?>
        <div class="o-table-wrapper">
            <table width="100%" class="o-table goyostats-new-table goyostats-table-inspect">
                <thead>
                    <tr>
                        <th scope="col" class="goyostats-pd-l">
                            <a href="<?php echo esc_url(Helper::getTableColumnSortUrl('name')); ?>" class="sort <?php echo Request::compare('order_by', 'name') ? esc_attr($order) : '' ?>"><?php echo esc_html($taxName); ?></a>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <a href="<?php echo esc_url(Helper::getTableColumnSortUrl('views')); ?>" class="sort <?php echo !Request::has('order_by') || Request::compare('order_by', 'views') ? esc_attr($order) : '' ?>">
                                <?php /* translators: %s: string value */ echo sprintf(esc_html__('%s Page Views', 'goyo-statistics'), $taxName); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </a>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <a href="<?php echo esc_url(Helper::getTableColumnSortUrl('post_count')); ?>" class="sort <?php echo Request::compare('order_by', 'post_count') ? esc_attr($order) : '' ?>">
                                <?php esc_html_e('Total Published Contents', 'goyo-statistics') ?>
                            </a>
                        </th>
                        <th scope="col">
                            <span class="screen-reader-text"><?php esc_html_e('View page detail', 'goyo-statistics'); ?></span>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($data as $category) : ?>
                        <tr>
                            <td class="goyostats-pd-l">
                                <a class="goyostats-table-ellipsis--name" href="<?php echo esc_url(Menus::admin_url('category-analytics', ['type' => 'single', 'term_id' => $category['term_id']])) ?>">
                                    <span title="<?php echo esc_attr($category['term_name']) ?>"><?php echo esc_html($category['term_name']) ?></span>
                                </a>
                            </td>
                            <td class="goyostats-pd-l"><?php echo esc_html(number_format_i18n($category['views'])) ?></td>
                            <td class="goyostats-pd-l"><?php echo esc_html(number_format_i18n($category['posts_count'])) ?></td>
                            <td class="goyostats-pd-l view-more view-more__arrow">
                                <a target="_blank" href="<?php echo esc_url(get_term_link(intval($category['term_id']))); ?>" title="<?php esc_html_e('View Category Page', 'goyo-statistics') ?>">
                                    <?php /* translators: %s: string value */ echo sprintf(esc_html__('View %s Page', 'goyo-statistics'), $taxName) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </a>
                            </td>
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
<?php echo isset($pagination) ? $pagination : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

