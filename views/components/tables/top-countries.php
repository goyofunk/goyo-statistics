<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Country;

?>

<div class="goyostats-card">
    <div class="goyostats-card__title">
        <h2>
            <?php echo isset($title) ? esc_html($title) : esc_html__('Top Countries', 'goyo-statistics'); ?>

            <?php if ($tooltip): ?>
                <span class="goyostats-tooltip" title="<?php echo esc_attr($tooltip); ?>"><i class="goyostats-tooltip-icon info"></i></span>
            <?php endif ?>
        </h2>
    </div>
    <div class="inside">
        <?php if (!empty($data)) : ?>
            <div class="o-table-wrapper">
                <table width="100%" class="o-table goyostats-new-table">
                    <thead>
                    <tr>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Country', 'goyo-statistics') ?>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <span class="goyostats-order">
                                <?php esc_html_e('Visitors', 'goyo-statistics') ?>
                            </span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $item) : ?>
                        <tr>
                            <td class="goyostats-pd-l">
                                <div>
                                    <img class="goyostats-flag" src="<?php echo esc_url(Country::flag($item->country)) ?>" alt="<?php echo esc_attr(Country::getName($item->country)) ?>">
                                    <?php echo esc_html(Country::getName($item->country)); ?>
                                </div>
                            </td>
                            <td class="goyostats-pd-l">
                                <span><?php echo esc_html(number_format_i18n($item->visitors)); ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="o-wrap o-wrap--no-data goyostats-center">
                <?php esc_html_e('No recent data available.', 'goyo-statistics') ?>
            </div>
        <?php endif; ?>

    </div>
</div>