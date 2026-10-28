<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/** @var Goyo_Statistics\Service\Admin\LicenseManagement\Plugin\PluginDecorator $addOn */
if (empty($addOn)) {
    return;
}

?>
<div class="goyostats-addon__download__item <?php echo !$included ? 'goyostats-addon__download__item--disabled' : ''; ?>">
    <div class="goyostats-addon__download__item--info">
        <div class="goyostats-addon__download__item--info__img">
            <img src="<?php echo esc_url($addOn->getIcon()); ?>" alt="<?php echo esc_attr($addOn->getName()); ?>">
        </div>
        <div class="goyostats-addon__download__item--info__text">
            <div class="goyostats-addon__download__item--info__title">
                <?php echo esc_html($addOn->getName()); ?>
                <?php if (!empty($addOn->getProductUrl())) : ?>
                    <a target="_blank" href="<?php echo esc_html($addOn->getProductUrl()); ?>/?utm_source=goyo-statistics&utm_medium=link&utm_campaign=<?php echo rawurlencode($addOn->getUtmCampaign()); ?>" class="goyostats-postbox-addon__read-more" aria-label="<?php esc_html_e('Learn More', 'goyo-statistics'); ?>">
                        <?php esc_html_e('Learn More', 'goyo-statistics'); ?>
                    </a>
                <?php endif; ?>

                <?php if ($included && $addOn->isUpdateAvailable()) : ?>
                    <span class="goyostats-postbox-addon__label goyostats-postbox-addon__label--updated"><?php esc_html_e('Update Available', 'goyo-statistics'); ?></span>
                <?php endif; ?>
            </div>
            <p class="goyostats-addon__download__item--info__desc">
                <?php echo wp_kses($addOn->getShortDescription(), 'data'); ?>
            </p>
        </div>
    </div>
    <div class="goyostats-addon__download__item--select">
        <?php if ($included && $addOn->isInstalled()) : ?>
            <span class="goyostats-postbox-addon__status goyostats-postbox-addon__status--installed "><?php esc_html_e('Already installed', 'goyo-statistics'); ?></span>
        <?php elseif (!$included) : ?>
            <span class="goyostats-postbox-addon__status goyostats-postbox-addon__status--primary "><?php esc_html_e('Not included', 'goyo-statistics'); ?></span>
        <?php endif; ?>

        <?php if ($included && (!$addOn->isInstalled() || $addOn->isUpdateAvailable())) : ?>
            <span> <input aria-label="<?php esc_html_e('Select to download and install addon', 'goyo-statistics'); ?>" type="checkbox" class="js-goyostats-addon-check-box" name="addon-select" data-slug="<?php echo esc_attr($addOn->getSlug()); ?>"></span>
        <?php endif; ?>
    </div>
</div>