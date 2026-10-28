<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-premium-box-feature">
    <div class="goyostats-premium-box-feature__head">
        <h1>
            <?php echo esc_html__('This Feature is Part of the', 'goyo-statistics'); ?>
            <span><?php echo esc_html__('DataPlus Add-on', 'goyo-statistics'); ?></span>
        </h1>
        <p>
            <?php echo esc_html__('The settings on this page are part of the DataPlus add-on, which enhances WP Statistics by expanding tracking capabilities and providing detailed visitor insights.', 'goyo-statistics'); ?>
        </p>
    </div>
    <div class="goyostats-premium-box__items">
        <div class="goyostats-premium-box__item">
            <?php echo esc_html__('Track custom post types and taxonomies.', 'goyo-statistics'); ?>
        </div>
        <div class="goyostats-premium-box__item">
            <?php echo esc_html__('Use advanced filtering for specific query parameters and UTM tags.', 'goyo-statistics'); ?>
        </div>
        <div class="goyostats-premium-box__item">
            <?php echo esc_html__('Monitor outbound link clicks and downloads.', 'goyo-statistics'); ?>
        </div>
        <div class="goyostats-premium-box__item">
            <?php echo esc_html__('Compare weekly traffic and view hourly visitor patterns.', 'goyo-statistics'); ?>
        </div>
        <div class="goyostats-premium-box__item">
            <?php echo esc_html__('Analyze individual content pieces with detailed widgets.', 'goyo-statistics'); ?>
        </div>
    </div>
    <div class="goyostats-premium-box__info">
        <?php echo esc_html__('Unlock deeper insights into your website\'s performance with DataPlus.', 'goyo-statistics'); ?>
    </div>
    <a data-target="goyo-statistics-data-plus" class="goyostats-show-premium-modal  js-goyostats-openPremiumModal button button-primary" href="<?php echo esc_url(GOYO_STATISTICS_SITE_URL . '/add-ons/goyo-statistics-data-plus/?utm_source=goyo-statistics&utm_medium=link&utm_campaign=dp-'.$campaign); ?>">
        <?php echo esc_html__('Upgrade Now.', 'goyo-statistics'); ?>
    </a>
</div>
<div class="goyostats-premium-box-image">
    <img alt="<?php echo esc_html__('DataPlus features', 'goyo-statistics'); ?>" src="<?php echo esc_url(GOYO_STATISTICS_URL . $src); ?>"/>
</div>