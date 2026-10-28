<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;
use GOYO_STATISTICS\Helper;

$isDataPlusActive = Helper::isAddOnActive('data-plus');

if (!$isDataPlusActive):
?>
    <div class="goyostats-filter-query-params goyostats-head-filters__item loading disabled">
        <button class="disabled goyostats-tooltip-premium">
            <?php esc_html_e('Query Parameter : All', 'goyo-statistics'); ?>
            <span class="goyostats-tooltip_templates tooltip-premium tooltip-premium--bottom tooltip-premium--right">
                <span id="tooltip_realtime">
                    <a data-target="goyo-statistics-data-plus" class="js-goyostats-openPremiumModal"> <?php esc_html_e('Learn More', 'goyo-statistics'); ?></a>
                    <span>
                        <?php esc_html_e('Premium Feature', 'goyo-statistics'); ?>
                    </span>
                </span>
            </span>
        </button>
    </div>
<?php
    return;
endif;
$args = [
    'title' => __('Query Parameter', 'goyo-statistics'),
    'type'  => 'query-params'
];

View::load("components/objects/header-filter-select", $args);
