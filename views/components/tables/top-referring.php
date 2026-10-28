<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Referred;

?>

<div class="goyostats-card">
    <div class="goyostats-card__title">
        <h2>
            <?php echo esc_html__('Top Referring', 'goyo-statistics') ?>
            <?php if ($tooltip): ?>
                <span class="goyostats-tooltip" title="<?php echo esc_attr($tooltip); ?>"><i class="goyostats-tooltip-icon info"></i></span>
            <?php endif ?>
        </h2>
    </div>
    <div class="inside">
        <?php if (!empty($data)) : ?>
            <div class="o-table-wrapper">
                <table width="100%" class="o-table goyostats-new-table goyostats-new-table__top-referring">
                    <thead>
                    <tr>
                        <th scope="col" class="goyostats-pd-l">
                            <?php echo esc_html__('Domain Address', 'goyo-statistics') ?>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <?php echo esc_html__('Number of Referrals', 'goyo-statistics') ?>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($data as $item) : ?>
                        <tr>
                            <td class="goyostats-pd-l">
                                <div class="goyostats-ellipsis-parent">
                                    <?php echo Referred::get_referrer_link($item->referred, '', true) ?>
                                </div>
                            </td>
                            <td class="goyostats-pd-l"><?php echo esc_html(number_format($item->visitors)) ?></td>
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