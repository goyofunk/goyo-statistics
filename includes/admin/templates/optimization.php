<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;
use Goyo_Statistics\Service\Admin\ModalHandler\Modal;

View::load('components/objects/share-anonymous-notice');
?>
<div class="goyostats-wrap__main">
    <div class="wp-header-end"></div>
    <div id="poststuff" class="goyostats-wrap__settings">
        <?php
        Modal::render('setting-confirmation', [
            'title'                => __('Confirmation', 'goyo-statistics'),
            'description'          => __('Are you sure you want to permanently delete this data?', 'goyo-statistics'),
            'primaryButtonText'    => __('Yes', 'goyo-statistics'),
            'primaryButtonStyle'   => 'danger',
            'secondaryButtonText'  => __('Cancel', 'goyo-statistics'),
            'secondaryButtonStyle' => 'cancel',
            'showCloseButton'      => true,
            'alert'                => __('This action cannot be undone.', 'goyo-statistics'),
            'actions'              => [
                'primary'   => 'resolve',
                'secondary' => 'closeModal',
            ],
        ]);
        ?>
        <div id="post-body" class="metabox-holder goyostats-optimizationPageFlex">
            <button class="goyostats-gototop" aria-label="Go to top of page"></button>
            <?php include GOYO_STATISTICS_DIR . 'includes/admin/templates/layout/menu-optimization.php'; ?>

            <div class="wp-list-table widefat goyostats-optimizationBox">
                <div class="goyo-statistics-container">
                    <div id="resources" class="tab-content current">
                        <?php include(GOYO_STATISTICS_DIR . 'includes/admin/templates/optimization/resources.php'); ?>
                    </div>
                    <div id="export" class="tab-content">
                        <?php include(GOYO_STATISTICS_DIR . 'includes/admin/templates/optimization/export.php'); ?>
                    </div>
                    <div id="purging" class="tab-content">
                        <?php include(GOYO_STATISTICS_DIR . 'includes/admin/templates/optimization/purging.php'); ?>
                    </div>
                    <div id="updates" class="tab-content">
                        <?php include(GOYO_STATISTICS_DIR . 'includes/admin/templates/optimization/updates.php'); ?>
                    </div>
                    <div id="historical" class="tab-content">
                        <?php include(GOYO_STATISTICS_DIR . 'includes/admin/templates/optimization/historical.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>