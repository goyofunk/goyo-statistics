<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Utils\Request;
use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Menus;

$order = Request::get('order', 'desc');
?>
    <div class="inside">
        <?php if (!empty($data)) : ?>
            <div class="o-table-wrapper">
                <!--screen readers -->
                <div id="table-summary" class="screen-reader-text">
                    <?php esc_html_e('This table displays author analytics, including author names, their page views, and total published content.', 'goyo-statistics'); ?>
                </div>
                <table class="o-table goyostats-new-table goyostats-table-inspect" aria-describedby="table-summary">
                    <thead>
                    <tr>
                        <th scope="col" class="goyostats-pd-l">
                            <a href="<?php echo esc_url(Helper::getTableColumnSortUrl('name')); ?>" class="sort <?php echo Request::compare('order_by', 'name') ? esc_attr($order) : '' ?>">
                                <?php esc_html_e('Author', 'goyo-statistics'); ?>
                            </a>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <a href="<?php echo esc_url(Helper::getTableColumnSortUrl('page_views')); ?>" class="sort <?php echo !Request::has('order_by') || Request::compare('order_by', 'page_views') ? esc_attr($order) : '' ?>">
                                <?php esc_html_e('Author\'s Page Views', 'goyo-statistics'); ?>
                            </a>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <a href="<?php echo esc_url(Helper::getTableColumnSortUrl('total_posts')); ?>" class="sort <?php echo Request::compare('order_by', 'total_posts') ? esc_attr($order) : '' ?>">
                                <?php esc_html_e('Published Contents', 'goyo-statistics'); ?>
                            </a>
                        </th>
                        <th scope="col">
                            <span class="screen-reader-text"><?php esc_html_e('View Author Page', 'goyo-statistics'); ?></span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $author) : ?>
                        <tr>
                            <td class="goyostats-pd-l">
                                <a class="goyostats-table-ellipsis--name" href="<?php echo esc_url(Menus::admin_url('author-analytics', ['type' => 'single-author', 'author_id' => $author->id])) ?>">
                                    <img class="goyostats-avatar" src="<?php echo esc_url(get_avatar_url($author->id)); ?>" alt="<?php echo esc_attr($author->name) ?>" role="presentation"/>
                                    <span><?php echo esc_html($author->name) ?></span>
                                </a>
                            </td>
                            <td class="goyostats-pd-l"><?php echo esc_html($author->page_views) ?></td>
                            <td class="goyostats-pd-l"><?php echo esc_html($author->total_posts) ?></td>
                            <td class="goyostats-pd-l view-more view-more__arrow">
                                <a target="_blank" href="<?php echo esc_url(get_author_posts_url($author->id)); ?>">
                                    <?php esc_html_e('View Author Page', 'goyo-statistics') ?>
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