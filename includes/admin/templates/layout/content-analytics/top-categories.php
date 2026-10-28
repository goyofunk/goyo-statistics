<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Utils\Request;

$postType = Helper::getPostTypeName(Request::get('tab', 'post'));
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
        <div class="goyostats-tabs">
            <?php 
                if (!empty($taxonomies)) :
                    $counter = 1; 
                    foreach ($taxonomies as $taxonomy => $terms) : ?>
                        <?php 
                            $taxName = get_taxonomy($taxonomy)->labels->menu_name;
                            if (empty($terms)) continue;
                        ?>
    
                        <input type="radio" name="content-category" id="<?php echo esc_attr('tax-' . $counter) ?>" <?php checked($counter, 1) ?>>
                        <label for="<?php echo esc_attr('tax-' . $counter) ?>"><?php echo esc_html($taxName) ?></label>
    
                        <div class="goyostats-tabs__content">
                            <?php foreach ($terms as $term) : ?>
                                <a class="goyostats-tabs-item" href="<?php echo esc_url(Menus::admin_url('category-analytics', ['type' => 'single', 'term_id' => $term['term_id']])) ?>">
                                    <div class="goyostats-content-tabs__item--content">
                                        <h3 class="goyostats-ellipsis-parent"><span class="goyostats-ellipsis-text"><?php echo esc_html($term['term_name']); ?></span></h3>
                                        <span><span class="goyostats-content-tabs__item--count"><?php /* translators: %s: string value */ echo esc_html($term['posts_count']); ?></span><?php echo sprintf(esc_html__('published %s', 'goyo-statistics'), strtolower($postType)) ?></span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <?php $counter++; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="o-wrap o-wrap--no-data"><?php esc_html_e('No recent data available.', 'goyo-statistics') ?></div>
                <?php endif;?>

        </div>
    </div>
</div>