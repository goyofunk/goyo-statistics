<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/** @var Goyo_Statistics\Service\Admin\LicenseManagement\Plugin\PluginDecorator $addOn */
if (empty($addOn)) {
    return;
}

?>
<div class="goyostats-postbox-addon__item">
    <div>
        <div class="goyostats-postbox-addon__item--info">
            <div class="goyostats-postbox-addon__item--info__img">
                 <img src="<?php echo esc_url($addOn->getIcon()); ?>" alt="<?php echo esc_html($addOn->getName()); ?>" />
             </div>
            <div class="goyostats-postbox-addon__item--info__text">
                <div class="goyostats-postbox-addon__item--info__title">
                    <a href="<?php echo esc_url($addOn->getProductUrl()); ?>?utm_source=goyo-statistics&utm_medium=link&utm_campaign=install-addon" target="_blank">
                        <?php echo esc_html($addOn->getName())?><span class="goyostats-postbox-addon__version">v<?php echo esc_html($addOn->getVersion())?></span>
                    </a>
                    <?php if (!empty($addOn->getLabel())) : ?>
                        <span class="goyostats-postbox-addon__label goyostats-postbox-addon__label--<?php echo esc_attr($addOn->getLabelClass()); ?>"><?php echo esc_html($addOn->getLabel()); ?></span>
                    <?php endif; ?>

                    <?php if ($addOn->isLicenseValid() && $addOn->isUpdateAvailable()) : ?>
                        <span class="goyostats-postbox-addon__label goyostats-postbox-addon__label--updated"><?php esc_html_e('Update Available', 'goyo-statistics'); ?></span>
                    <?php endif; ?>
                </div>
                <p class="goyostats-postbox-addon__item--info__desc">
                    <?php echo wp_kses($addOn->getShortDescription(), 'data'); ?>
                </p>
            </div>
        </div>
        <div class="goyostats-postbox-addon__item--actions">
            <span class="goyostats-postbox-addon__status goyostats-postbox-addon__status--<?php echo esc_attr($addOn->getStatusClass()); ?> "><?php echo esc_html($addOn->getStatusLabel()); ?></span>
            <div class="goyostats-postbox-addon__buttons">
                <?php if ($addOn->isInstalled() && !$addOn->isActivated()) : ?>
                    <a class="goyostats-postbox-addon__button js-addon-active-plugin-btn" data-slug="<?php echo esc_attr($addOn->getSlug()); ?>" aria-label="<?php esc_html_e('Active', 'goyo-statistics'); ?>"><?php esc_html_e('Active', 'goyo-statistics'); ?></a>
                <?php endif; ?>
                <?php if ($addOn->isInstalled()) : ?>
                    <a class="goyostats-postbox-addon__button js-goyostats-addon-license-button"><?php esc_html_e('License', 'goyo-statistics'); ?></a>
                <?php endif; ?>
            </div>
            <div class="goyostats-addon--actions">
                <span class="goyostats-addon--actions--show-more js-addon-show-more"></span>
                <ul class="goyostats-addon--submenus">
                    <?php if ($addOn->isActivated()) : ?>
                        <li><a href="<?php echo esc_url($addOn->getSettingsUrl()); ?>" class="goyostats-addon--submenu goyostats-addon--submenu__settings" target="_blank"><span><?php esc_html_e('Settings', 'goyo-statistics'); ?></span></a></li>
                        <li><span class="goyostats-separator"></span></li>
                    <?php endif; ?>
                    <li><a href="<?php echo esc_url($addOn->getProductUrl()); ?>?utm_source=goyo-statistics&utm_medium=link&utm_campaign=install-addon" class="goyostats-addon--submenu" target="_blank"><?php esc_html_e('Add-on Details', 'goyo-statistics'); ?></a></li>
                    <?php if (!empty($addOn->getChangelogUrl())) : ?>
                        <li><a href="<?php echo esc_url($addOn->getChangelogUrl()); ?>&utm_source=goyo-statistics&utm_medium=link&utm_campaign=install-addon" class="goyostats-addon--submenu" target="_blank"><?php esc_html_e('Changelog', 'goyo-statistics'); ?></a></li>
                    <?php endif; ?>
                    <?php if (!empty($addOn->getDocumentationUrl())) : ?>
                        <li><a href="<?php echo esc_url($addOn->getDocumentationUrl()); ?>?utm_source=goyo-statistics&utm_medium=link&utm_campaign=install-addon" class="goyostats-addon--submenu" target="_blank"><?php esc_html_e('Documentation', 'goyo-statistics'); ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="goyostats-addon__item__license js-goyostats-addon-license">
        <div class="goyostats-addon__item__update_license">
            <input aria-label="<?php esc_html_e('License', 'goyo-statistics'); ?>" id="<?php echo esc_attr($addOn->getSlug()) ?>-input" data-addon-slug="<?php echo esc_attr($addOn->getSlug()) ?>" type="text" placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" value="<?php echo esc_attr($addOn->getLicenseKey()) ?>">
            <button><?php esc_html_e('Update License', 'goyo-statistics'); ?></button>
        </div>
        <?php if (isset($alert_text)) : ?>
            <div class="goyostats-alert goyostats-alert--<?php echo esc_attr($alert_class); ?>">
                <span class="icon"></span>
                <div>
                    <p><?php echo esc_html($alert_text); ?></p>
                    <?php if (isset($alert_link_text)) : ?>
                        <div>
                            <a href="<?php echo esc_url($alert_link); ?>" class="js-goyostats-addon-check-box" title="<?php echo esc_attr($alert_link_text); ?>"><?php echo esc_html($alert_link_text); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
     </div>

</div>