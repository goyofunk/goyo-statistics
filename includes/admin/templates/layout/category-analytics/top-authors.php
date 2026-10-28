<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Menus;

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
                <input type="radio" name="views-tab" id="category-views" checked="checked">
                <label for="category-views"><?php esc_html_e('Views', 'goyo-statistics') ?></label>
                <div class="goyostats-tabs__content">
                    <?php
                    /** @var stdClass[] */
                    $viewingAuthors = $data['viewing'];
                    $counter        = 1;

                    if ($viewingAuthors) {
                        foreach ($viewingAuthors as $author) : ?>
                            <a class="goyostats-tabs-item" href="<?php echo esc_url(Menus::admin_url('author-analytics', ['type' => 'single-author', 'author_id' => $author->id])); ?>">
                                <div class="goyostats-content-tabs__item--image">
                                    <span># <?php echo esc_html($counter); ?></span>
                                    <img src="<?php echo esc_url(get_avatar_url($author->id)); ?>" alt="<?php echo esc_html($author->name); ?>"/>
                                </div>
                                <div class="goyostats-content-tabs__item--content">
                                    <h3 class="goyostats-ellipsis-parent"><span class="goyostats-ellipsis-text"><?php echo esc_html($author->name); ?></span></h3>
                                    <span><span class="goyostats-content-tabs__item--count"><?php echo esc_html(Helper::formatNumberWithUnit($author->total_views)); ?></span><?php esc_html_e('content views', 'goyo-statistics') ?></span>
                                </div>
                            </a>
                            <?php $counter++;
                        endforeach;
                    } else {
                        ?>
                        <div class="o-wrap o-wrap--no-data">
                            <p><?php esc_html_e('No recent data available.', 'goyo-statistics') ?></p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="goyostats-flex-half">
            <div class="goyostats-tabs">
                <input type="radio" name="publishing-tabs" id="category-publishing" checked="checked">
                <label for="category-publishing"><?php esc_html_e('Publishing', 'goyo-statistics') ?></label>
                <div class="goyostats-tabs__content">
                    <?php
                    /** @var stdClass[] */
                    $publishingAuthors = $data['publishing'];
                    $counter           = 1;

                    if ($publishingAuthors) {
                        foreach ($publishingAuthors as $author) : ?>
                            <a class="goyostats-tabs-item" href="<?php echo esc_url(Menus::admin_url('author-analytics', ['type' => 'single-author', 'author_id' => $author->id])); ?>">
                                <div class="goyostats-content-tabs__item--image">
                                    <span># <?php echo esc_html($counter); ?></span>
                                    <img src="<?php echo esc_url(get_avatar_url($author->id)); ?>" alt="<?php echo esc_html($author->name); ?>"/>
                                </div>
                                <div class="goyostats-content-tabs__item--content">
                                    <h3 class="goyostats-ellipsis-parent"><span class="goyostats-ellipsis-text"><?php echo esc_html($author->name); ?></span></h3>
                                    <span><span class="goyostats-content-tabs__item--count"><?php echo esc_html(Helper::formatNumberWithUnit($author->post_count)); ?></span><?php esc_html_e('content published', 'goyo-statistics'); ?></span>
                                </div>
                            </a>
                            <?php $counter++;
                        endforeach;
                    } else {
                        ?>
                        <div class="o-wrap o-wrap--no-data">
                            <p><?php esc_html_e('No recent data available.', 'goyo-statistics') ?></p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>