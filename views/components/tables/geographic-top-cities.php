<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Country;
use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Menus;

?>

<?php if (empty($dashboard_widget)) : ?>
<div class="goyostats-card">
    <div class="goyostats-card__title">
        <h2>
            <?php echo esc_html__('Top Cities', 'goyo-statistics') ?>
        </h2>
    </div>
    <div class="inside">
<?php endif; ?>
        <?php if (!empty($data)) : ?>
            <div class="o-table-wrapper">
                <table width="100%" class="o-table goyostats-new-table">
                    <thead>
                    <tr>
                        <th class="goyostats-pd-l">
                            <?php esc_html_e('City', 'goyo-statistics') ?>
                        </th>
                        <th class="goyostats-pd-l">
                            <?php esc_html_e('Region', 'goyo-statistics') ?>
                        </th>
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
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $item) : ?>
                        <tr>
                            <td class="goyostats-pd-l">
                                <span class="truncate" title="<?php echo esc_attr($item->city); ?>"><?php echo esc_html($item->city); ?></span>
                            </td>
                            <td class="goyostats-pd-l">
                                <span class="truncate" title="<?php echo esc_attr($item->region); ?>"><?php echo esc_html($item->region); ?></span>
                            </td>
                            <td class="goyostats-pd-l">
                                <div class="goyostats-country-name">
                                    <span class="truncate" title="<?php echo esc_attr(Country::getName($item->country)); ?>"><?php echo esc_html(Country::getName($item->country)); ?></span>
                                </div>
                            </td>
                            <td class="goyostats-pd-l">
                                <span><?php echo esc_html(number_format_i18n($item->visitors)); ?></span>
                            </td>
                            <td class="goyostats-pd-l">
                                <span><?php echo esc_html(number_format_i18n($item->views)); ?></span>
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
<?php if (empty($dashboard_widget)) : ?>
    </div>
    <div class="goyostats-card__footer">
        <div class="goyostats-card__footer__more">
            <a class="goyostats-card__footer__more__link" href="<?php echo esc_url(Menus::admin_url('geographic', ['tab' => 'cities'])); ?>">
                <?php esc_html_e('View Cities', 'goyo-statistics') ?>
            </a>
        </div>
    </div>
</div>
<?php endif; ?>
