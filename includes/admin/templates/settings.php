<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;

View::load('components/objects/share-anonymous-notice');
?>
<div class="goyostats-wrap__main">
    <div class="wp-header-end"></div>

<div id="poststuff" class="goyostats-wrap__settings">
    <button class="goyostats-gototop" aria-label="Go to top of page"></button>
    <div id="post-body" class="metabox-holder goyostats-settingsPageFlex">
        <?php include GOYO_STATISTICS_DIR . 'includes/admin/templates/layout/menu-settings.php'; ?>

        <div class="wp-list-table widefat goyostats-settingsBox">
            <form id="goyo-statistics-settings-form" method="post">
                <?php wp_nonce_field('update-options', 'goyo-statistics-nonce'); ?>

                <div class="goyo-statistics-container">
                    <?php if ($goyostats_admin) { ?>
                         <div id="general-settings" class="tab-content current">
                            <?php include GOYO_STATISTICS_DIR . 'includes/admin/templates/settings/general.php'; ?>
                        </div>
                        <div id="advanced-settings" class="tab-content">
                            <?php include GOYO_STATISTICS_DIR . 'includes/admin/templates/settings/advanced.php'; ?>
                        </div>
                        <div id="privacy-settings" class="tab-content">
                            <?php include GOYO_STATISTICS_DIR . 'includes/admin/templates/settings/privacy.php'; ?>
                        </div>
                        <div id="display-settings" class="tab-content">
                            <?php include GOYO_STATISTICS_DIR . 'includes/admin/templates/settings/display.php'; ?>
                        </div>
                        <div id="notifications-settings" class="tab-content">
                            <?php include GOYO_STATISTICS_DIR . 'includes/admin/templates/settings/notifications.php'; ?>
                        </div>
                        <div id="access-settings" class="tab-content">
                            <?php include GOYO_STATISTICS_DIR . 'includes/admin/templates/settings/access-level.php'; ?>
                        </div>
                        <div id="exclusions-settings" class="tab-content">
                            <?php include GOYO_STATISTICS_DIR . 'includes/admin/templates/settings/exclusions.php'; ?>
                        </div>
                    <?php } ?>
                </div><!-- container -->
                 <input type="hidden" name="tab" id="goyostats_current_tab" value=""/>
            </form>
        </div>
    </div>
</div>
