<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Components\View;
use Goyo_Statistics\Decorators\ReferralDecorator;

?>

<div class="inside">
    <?php if (!empty($data)) : ?>
        <div class="o-table-wrapper">
            <table width="100%" class="o-table goyostats-new-table">
                <thead>
                <tr>
                    <th scope="col" class="goyostats-pd-l">
                        <?php esc_html_e('Domain Address', 'goyo-statistics') ?>
                    </th>
                    <th scope="col" class="goyostats-pd-l">
                            <span class="goyostats-order">
                                <?php esc_html_e('Referrals', 'goyo-statistics') ?>
                            </span>
                    </th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($data as $item) : ?>
                    <?php /** @var ReferralDecorator $item * */ ?>

                    <tr>
                        <td class="goyostats-pd-l">
                            <?php
                            View::load("components/objects/external-link", [
                                'url'   => $item->getReferrer(),
                                'title' => $item->getRawReferrer()
                            ]);
                            ?>
                        </td>

                        <td class="goyostats-pd-l goyostats-middle-vertical">
                            <a href="<?php echo esc_url(Menus::admin_url('referrals', ['tab' => 'referred-visitors', 'referrer' => $item->getRawReferrer()])) ?>"><?php echo esc_html($item->getTotalReferrals()) ?></a>
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