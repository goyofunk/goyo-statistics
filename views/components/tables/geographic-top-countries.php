<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Country;
use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Service\Admin\LicenseManagement\Plugin\PluginHandler;

$pluginHandler = new PluginHandler();
$isActive      = $pluginHandler->isPluginActive('goyo-statistics-data-plus');
?>

<div class="goyostats-card">
    <div class="goyostats-card__title">
        <h2>
            <?php echo esc_html__('Top Countries', 'goyo-statistics') ?>
        </h2>
    </div>
    <div class="inside">
        <?php if (!empty($data)) : ?>
            <div class="o-table-wrapper">
                <table width="100%" class="o-table goyostats-new-table">
                    <thead>
                    <tr>
                        <th class="goyostats-pd-l">
                            <?php esc_html_e('Country', 'goyo-statistics') ?>
                        </th>
                        <th class="goyostats-pd-l">
                                <span class="goyostats-order">
                                    <?php esc_html_e('Visitors', 'goyo-statistics') ?>
                                </span>
                        </th>
                        <th class="goyostats-pd-l">
                            <?php esc_html_e('Views', 'goyo-statistics') ?>
                        </th>
                        <th class="goyostats-pd-l"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $country) : ?>
                        <tr>
                            <td class="goyostats-pd-l">
                                <div class="goyostats-country-name">
                                    <img class="goyostats-flag" src="<?php echo esc_url(Country::flag($country->country)); ?>" alt="<?php echo esc_attr(Country::getName($country->country)); ?>">
                                    <span class="truncate" title="<?php echo esc_attr(Country::getName($country->country)); ?>"><?php echo esc_html(Country::getName($country->country)); ?></span>
                                </div>
                            </td>
                            <td class="goyostats-pd-l">
                                <span><?php echo esc_html(number_format_i18n($country->visitors)); ?></span>
                            </td>
                            <td class="goyostats-pd-l">
                                <span><?php echo esc_html(number_format_i18n($country->views)); ?></span>
                            </td>
                            <td class="-table__cell o-table__cell--right view-more">
                                <?php if ($isActive): ?>
                                    <a href="<?php echo esc_url(Menus::admin_url('geographic', ['type' => 'single-country', 'country' => $country->country ?? Country::$unknown_location])) ?>" aria-label="View Details">
                                        <?php esc_html_e('View Details', 'goyo-statistics') ?>
                                    </a>
                                <?php else: ?>
                                    <div>
                                        
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="o-wrap o-wrap--no-data goyostats-center">
                <?php echo esc_html(Helper::getNoDataMessage()); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="goyostats-card__footer">
        <div class="goyostats-card__footer__more">
            <a class="goyostats-card__footer__more__link" href="<?php echo esc_url(Menus::admin_url('geographic', ['tab' => 'countries'])) ?>">
                <?php esc_html_e('View Countries', 'goyo-statistics') ?>
            </a>
        </div>
    </div>
</div>