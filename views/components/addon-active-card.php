<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/** @var Goyo_Statistics\Service\Admin\LicenseManagement\Plugin\PluginDecorator $addOn */
if (empty($addOn)) {
    return;
}

?>
<div class="goyostats-addon__download__item">
    <div class="goyostats-addon__download__item--info">
        <div class="goyostats-addon__download__item--info__img">
            <img src="<?php echo esc_url($addOn->getIcon()); ?>" alt="<?php echo esc_attr($addOn->getName()); ?>">
        </div>
        <div class="goyostats-addon__download__item--info__text">
            <div class="goyostats-addon__download__item--info__title">
                <?php echo esc_html($addOn->getName()); ?>
            </div>
            <p class="goyostats-addon__download__item--info__desc">
                <?php echo wp_kses($addOn->getShortDescription(), 'data'); ?>
            </p>
        </div>
    </div>
    <div class="goyostats-addon__download__item--actions">
        <?php if (in_array($addOn->getSlug(), $selectedAddOns) && (!$addOn->isInstalled() || $addOn->isUpdateAvailable())) : ?>
            <span class="goyostats-postbox-addon__status goyostats-postbox-addon__status--danger "><?php esc_html_e('Failed', 'goyo-statistics'); ?></span>
        <?php elseif ($addOn->isActivated()) : ?>
            <span class="goyostats-postbox-addon__status goyostats-postbox-addon__status--success "><?php esc_html_e('Activated', 'goyo-statistics'); ?></span>
        <?php endif; ?>

        <div class="goyostats-postbox-addon__buttons">
            <?php if (in_array($addOn->getSlug(), $selectedAddOns) && (!$addOn->isInstalled() || $addOn->isUpdateAvailable())) : ?>
                <a class="goyostats-postbox-addon__button button-retry-addon-download js-addon-retry-btn" data-slug="<?php echo esc_attr($addOn->getSlug()); ?>" aria-label="<?php esc_html_e('Retry', 'goyo-statistics'); ?>"><?php esc_html_e('Retry', 'goyo-statistics'); ?></a>
            <?php elseif ($addOn->isInstalled() && !$addOn->isActivated() ) : ?>
                <a class="goyostats-postbox-addon__button button-activate-addon js-addon-active-plugin-btn" data-slug="<?php echo esc_attr($addOn->getSlug()); ?>" aria-label="<?php esc_html_e('Active', 'goyo-statistics'); ?>"><?php esc_html_e('Active', 'goyo-statistics'); ?></a>
            <?php endif; ?>
        </div>


        <div class="goyostats-addon--actions <?php echo !$addOn->isInstalled() ? 'goyostats-hide' : ''; ?>">
            <span class="goyostats-addon--actions--show-more js-addon-show-more"></span>
            <ul class="goyostats-addon--submenus">
                <?php if ($addOn->isActivated()) : ?>
                    <li><a target="_blank" href="<?php echo esc_url($addOn->getSettingsUrl()); ?>" class="goyostats-addon--submenu goyostats-addon--submenu__settings"><?php esc_html_e('Settings', 'goyo-statistics'); ?></a></li>
                <?php endif; ?>
                <?php if (!empty($addOn->getProductUrl())) : ?>
                    <li><a href="<?php echo esc_url($addOn->getProductUrl()); ?>/?utm_source=goyo-statistics&utm_medium=link&utm_campaign=<?php echo rawurlencode($addOn->getUtmCampaign()); ?>" class="goyostats-addon--submenu" target="_blank"><?php esc_html_e('Add-on Details', 'goyo-statistics'); ?></a></li>
                <?php endif; ?>
                <?php if (!empty($addOn->getChangelogUrl())) : ?>
                    <li><a href="<?php echo esc_url($addOn->getChangelogUrl()); ?>&?utm_source=goyo-statistics&utm_medium=link&utm_campaign=<?php echo rawurlencode($addOn->getUtmCampaign()); ?>&releases=<?php echo rawurlencode($addOn->getUtmCampaign()); ?>" class="goyostats-addon--submenu" target="_blank"><?php esc_html_e('Changelog', 'goyo-statistics'); ?></a></li>
                <?php endif; ?>
                <?php if (!empty($addOn->getDocumentationUrl())) : ?>
                    <li><a href="<?php echo esc_url($addOn->getDocumentationUrl()); ?>/?utm_source=goyo-statistics&utm_medium=link&utm_campaign=<?php echo rawurlencode($addOn->getUtmCampaign()); ?>" class="goyostats-addon--submenu" target="_blank"><?php esc_html_e('Documentation', 'goyo-statistics'); ?></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>