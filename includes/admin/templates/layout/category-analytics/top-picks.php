<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Utils\Request;
use Goyo_Statistics\Components\View;

$taxonomy = Request::get('tx', 'category');
?>

<div class="goyostats-card">
    <div class="goyostats-card__title">
        <h2>
            <?php echo esc_html($title) ?>
            <?php if ($tooltip): ?>
                <span class="goyostats-tooltip" title="<?php echo esc_attr($tooltip); ?>"><i class="goyostats-tooltip-icon info"></i></span>
            <?php endif ?>
        </h2>
    </div>
    <div class="goyostats-flex-container">
        <div class="goyostats-flex-half">
            <div class="goyostats-tabs">
                <input type="radio" name="tabs" id="category-most-popular" checked="checked">
                <label for="category-most-popular"><?php esc_html_e('Most Popular', 'goyo-statistics') ?></label>
                <div class="goyostats-tabs__content">
                    <?php
                    if (!empty($data['top_viewing'])) {
                        $counter = 1;

                        foreach ($data['top_viewing'] as $post) {
                            $item = [
                                'href'        => Menus::admin_url('content-analytics', ['type' => 'single', 'post_id' => $post->ID]),
                                'counter'     => $counter,
                                'count'       => Helper::formatNumberWithUnit($post->views),
                                'count_title' => __('views', 'goyo-statistics'),
                                'post'        => $post,
                            ];
                            View::load("components/tabs-item", $item);
                            $counter++;
                        }
                    } else {
                        ?>
                        <div class="o-wrap o-wrap--no-data"><p><?php esc_html_e('No recent data available.', 'goyo-statistics') ?></p></div><?php
                    }
                    ?>
                </div>

                <input type="radio" name="tabs" id="category-most-commented">
                <label for="category-most-commented"><?php esc_html_e('Most Commented', 'goyo-statistics') ?></label>
                <div class="goyostats-tabs__content">
                    <?php
                    if (!empty($data['top_commented'])) {
                        $counter = 1;

                        foreach ($data['top_commented'] as $post) {
                            $item = [
                                'href'        => Menus::admin_url('content-analytics', ['type' => 'single', 'post_id' => $post->ID]),
                                'counter'     => $counter,
                                'count'       => number_format_i18n($post->comments),
                                'count_title' => __('comments', 'goyo-statistics'),
                                'post'        => $post,
                            ];
                            View::load("components/tabs-item", $item);
                            $counter++;
                        }
                    } else {
                        ?>
                        <div class="o-wrap o-wrap--no-data"><p><?php esc_html_e('No recent data available.', 'goyo-statistics') ?></p></div><?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="goyostats-flex-half">
            <div class="goyostats-tabs">
                <input type="radio" name="side-tabs" id="category-recent" checked="checked">
                <label for="category-recent"><?php esc_html_e('Recent', 'goyo-statistics') ?></label>
                <div class="goyostats-tabs__content">
                    <?php
                    if (!empty($data['recent'])) {
                        $counter = 1;

                        foreach ($data['recent'] as $post) {
                            $item = [
                                'href'        => Menus::admin_url('content-analytics', ['type' => 'single', 'post_id' => $post->ID]),
                                'counter'     => $counter,
                                'count'       => Helper::formatNumberWithUnit($post->views),
                                'count_title' => __('views', 'goyo-statistics'),
                                'post'        => $post,
                            ];
                            View::load("components/tabs-item", $item);
                            $counter++;
                        }
                    } else {
                        ?>
                        <div class="o-wrap o-wrap--no-data"><p><?php esc_html_e('No recent data available.', 'goyo-statistics') ?></p></div><?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (Menus::in_page('category-analytics') && !Request::compare('type', 'single')) {
        View::load("components/objects/view-more", [
            'href'  => add_query_arg(['tab' => 'top'], Menus::admin_url('pages')),
            'title' => __('See all contents', 'goyo-statistics'),
        ]);
    } ?>
</div>