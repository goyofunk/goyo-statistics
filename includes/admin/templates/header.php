<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Admin_Template;
use Goyo_Statistics\Components\View;
use GOYO_STATISTICS\Menus;
use GOYO_STATISTICS\Option;
use GOYO_STATISTICS\User;
use Goyo_Statistics\Service\Admin\LicenseManagement\LicenseHelper;
use Goyo_Statistics\Service\Admin\LicenseManagement\Plugin\PluginHelper;
use Goyo_Statistics\Service\Admin\ModalHandler\Modal;
use Goyo_Statistics\Service\Admin\PrivacyAudit\PrivacyAuditDataProvider;
use Goyo_Statistics\Service\Admin\Notification\NotificationFactory;
use Goyo_Statistics\Service\Admin\MarketingCampaign\MarketingCampaignFactory;

$userOnline              = new \GOYO_STATISTICS\UserOnline();
$isPremium               = LicenseHelper::isPremiumLicenseAvailable() ? true : false;
$hasUpdatedNotifications = NotificationFactory::hasUpdatedNotifications();
$displayNotifications    = GOYO_STATISTICS\Option::get('display_notifications') ? true : false;
$promoBanner             = MarketingCampaignFactory::getLatestMarketingCampaignByType('promo_banner');
$manageCap               = User::ExistCapability(Option::get('manage_capability', 'manage_options'));
$hasManageCap            = $manageCap && current_user_can($manageCap);

?>

    <div class="goyostats-adminHeader <?php echo $isPremium ? 'goyostats-adminHeader__premium' : '' ?>">
        <div class="goyostats-adminHeader__logo--container">
            <strong class="goyostats-adminHeader__logo">Goyo Statistics</strong>
        </div>
        <div class="goyostats-adminHeader__menu">
            <?php
            echo Admin_Template::get_template('layout/partials/menu-link', ['slug' => 'goyostats_overview_page', 'link_text' => __('Overview', 'goyo-statistics'), 'icon_class' => 'overview', 'badge_count' => null], true);
            if ($userOnline::active()) {
                echo Admin_Template::get_template('layout/partials/menu-link', ['slug' => 'goyostats_visitors_page&tab=online', 'link_text' => __('Online Visitors', 'goyo-statistics'), 'icon_class' => 'online-users', 'badge_count' => goyo_statistics_useronline()], true);
            }
            if (!$isPremium && apply_filters('goyo_statistics_enable_header_addons_menu', true)) {
                echo Admin_Template::get_template('layout/partials/menu-link', ['slug' => 'goyostats_plugins_page', 'link_text' => __('Add-ons', 'goyo-statistics'), 'icon_class' => 'addons', 'badge_count' => null], true);
            }
            if ($isPremium) {
                echo Admin_Template::get_template('layout/partials/menu-link', [
                    'slug'        => '',
                    'link_text'   => __('Quick Access', 'goyo-statistics'),
                    'icon_class'  => 'quick-access',
                    'badge_count' => null,
                    'sub_menu'    => [
                        [
                            'slug'       => 'goyostats_pages_page',
                            'link_text'  => __('Top Pages', 'goyo-statistics'),
                            'icon_class' => 'top-pages'
                        ],
                        [
                            'slug'       => 'goyostats_content-analytics_page',
                            'link_text'  => __('Content Analytics', 'goyo-statistics'),
                            'icon_class' => 'content-analytics'
                        ],
                        [
                            'slug'       => 'goyostats_author-analytics_page',
                            'link_text'  => __('Author Analytics', 'goyo-statistics'),
                            'icon_class' => 'author-analytics'
                        ]
                    ]
                ], true);
            }

            ?>
        </div>
        <div class="goyostats-adminHeader__side">
            <?php if (apply_filters('goyo_statistics_enable_upgrade_to_bundle', true)) : ?>
                <?php echo LicenseHelper::renderLicenseStatusLink($isPremium, $promoBanner); ?>
            <?php endif; ?>

            <?php if (Option::get('privacy_audit')) : ?>
                <?php
                $privacyAuditData   = new PrivacyAuditDataProvider();
                $privacyAuditStatus = $privacyAuditData->getComplianceStatus();
                ?>
                <a href="<?php echo esc_url(Menus::admin_url('privacy-audit')); ?>" title="<?php esc_html_e('Privacy Audit', 'goyo-statistics'); ?>" class="privacy <?php echo $privacyAuditStatus['percentage_ready'] != 100 ? 'warning' : ''; ?> <?php echo Menus::in_page('privacy-audit') ? 'active' : ''; ?>"></a>
            <?php endif; ?>

            <?php if ($hasManageCap): ?>

            <a href="<?php echo esc_url(admin_url('admin.php?page=goyostats_settings_page')); ?>" title="<?php esc_html_e('Settings', 'goyo-statistics'); ?>" class="settings <?php if (isset($_GET['page']) && $_GET['page'] === 'goyostats_settings_page') {
                echo 'active';
            } ?>"></a>
            <?php endif; ?>
            <?php if (apply_filters('goyo_statistics_enable_help_icon', true) && $hasManageCap) { ?>
                <a href="<?php echo esc_url(GOYO_STATISTICS_SITE_URL . '/support/?utm_source=goyo-statistics&utm_medium=link&utm_campaign=header'); ?>" target="_blank" title="<?php esc_html_e('Help Center', 'goyo-statistics'); ?>" class="support"></a>
            <?php } ?>

            <?php if ($displayNotifications): ?>

                <a href="#" title="<?php esc_html_e('Notifications', 'goyo-statistics'); ?>" class="goyostats-notifications js-goyostats-open-notification <?php echo $hasUpdatedNotifications ? esc_attr('goyostats-notifications--has-items') : ''; ?>"></a>
            <?php endif; ?>
            <div class="goyostats-adminHeader__mobileMenu">
                <input type="checkbox" id="goyostats-menu-toggle" class="hamburger-menu">
                <label for="goyostats-menu-toggle" class="hamburger-menu-container">
                    <div class="hamburger-menu-bar">
                        <div class="menu-bar"></div>
                        <div class="menu-bar"></div>
                        <div class="menu-bar"></div>
                    </div>
                    <span><?php esc_html_e('Menu', 'goyo-statistics'); ?></span>
                </label>
                <div class="goyostats-mobileMenuContent">
                    <?php
                    if (!$isPremium && apply_filters('goyo_statistics_enable_header_addons_menu', true)) {
                        echo Admin_Template::get_template('layout/partials/menu-link', ['slug' => 'goyostats_plugins_page', 'link_text' => __('Add-ons', 'goyo-statistics'), 'icon_class' => 'addons', 'badge_count' => null], true);
                    }
                    if ($isPremium) {
                        echo Admin_Template::get_template('layout/partials/menu-link', ['slug' => 'goyostats_pages_page', 'link_text' => __('Top Pages', 'goyo-statistics'), 'icon_class' => 'top-pages', 'badge_count' => null], true);
                        echo Admin_Template::get_template('layout/partials/menu-link', ['slug' => 'goyostats_content-analytics_page', 'link_text' => __('Content Analytics', 'goyo-statistics'), 'icon_class' => 'content-analytics', 'badge_count' => null], true);
                        echo Admin_Template::get_template('layout/partials/menu-link', ['slug' => 'goyostats_author-analytics_page', 'link_text' => __('Author Analytics', 'goyo-statistics'), 'icon_class' => 'author-analytics', 'badge_count' => null], true);
                    }
                    if ($hasManageCap) {
                        echo Admin_Template::get_template('layout/partials/menu-link', ['slug' => 'goyostats_settings_page', 'link_text' => __('Settings', 'goyo-statistics'), 'icon_class' => 'settings', 'badge_count' => null], true);
                    }
                    ?>
                    <?php if ($displayNotifications): ?>
                        <div class="goyostats-admin-header__menu-item">
                            <a class="goyostats-notifications js-goyostats-open-notification <?php echo $hasUpdatedNotifications ? esc_attr('goyostats-notifications--has-items') : ''; ?>">
                                <span class="icon"></span><span><?php esc_html_e('Notifications', 'goyo-statistics'); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if (apply_filters('goyo_statistics_enable_help_icon', true) && $hasManageCap) { ?>
                        <div>
                            <a href="<?php echo esc_url(GOYO_STATISTICS_SITE_URL . '/support/?utm_source=goyo-statistics&utm_medium=link&utm_campaign=header'); ?>" target="_blank" title="<?php esc_html_e('Help Center', 'goyo-statistics'); ?>" class="help">
                                <span class="icon"></span>
                                <?php esc_html_e('Help Center', 'goyo-statistics'); ?>
                            </a>
                        </div>
                    <?php }

                    if (apply_filters('goyo_statistics_enable_upgrade_to_bundle', true)) {
                        echo '<div class="goyostats-bundle">' . LicenseHelper::renderLicenseStatusLink($isPremium, $promoBanner, true) . '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
if ($displayNotifications) {
    View::load("components/notification/side-bar", ['notifications' => NotificationFactory::getAllNotifications()]);
}
Modal::render('introduce-premium'); ?>