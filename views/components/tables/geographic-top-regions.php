<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Menus;

?>

<div class="goyostats-card">
    <div class="goyostats-card__title">
        <h2>
            <?php echo esc_html($title); ?>
        </h2>
    </div>
    <div class="inside">
        <?php if (!empty($data)) : ?>
            <div class="o-table-wrapper">
                <table width="100%" class="o-table goyostats-new-table">
                    <thead>
                    <tr>
                        <th class="goyostats-pd-l">
                            <?php echo esc_html($top_title); ?>
                        </th>
                        <th class="goyostats-pd-l">
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
                                <?php echo esc_html($item->region); ?>
                            </td>
                            <td class="goyostats-pd-l">
                                <?php echo esc_html(number_format_i18n($item->visitors)) ?>
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
            <a class="goyostats-card__footer__more__link" href="<?php echo esc_url($footer_link) ?>">
                <?php echo esc_html($footer_title); ?>
            </a>
        </div>
    </div>
</div>