<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Admin_Template;
use Goyo_Statistics\Decorators\ReferralDecorator;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Service\Analytics\Referrals\SourceChannels;

?>

    <div class="inside">
        <?php if (!empty($referrers)) : ?>
            <div class="o-table-wrapper">
                <table width="100%" class="o-table goyostats-new-table goyostats-new-table--referrers">
                    <thead>
                    <tr>
                        <th scope="col" class="goyostats-pd-l">
                            <span><?php esc_html_e('Domain Address', 'goyo-statistics') ?></span>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Source Name', 'goyo-statistics') ?>
                        </th>
                        <th scope="col" class="goyostats-pd-l start">
                            <span class="goyostats-order"><?php esc_html_e('Number of Referrals', 'goyo-statistics') ?></span>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($referrers as $referrer) : ?>
                        <?php /** @var ReferralDecorator $referrer */ ?>
                        <tr>
                            <td class="goyostats-pd-l">
                                <?php if (!empty($referrer->getRawReferrer())) : ?>
                                    <a href="<?php echo esc_url($referrer->getReferrer()) ?>" title="<?php echo esc_html($referrer->getRawReferrer()) ?>" target="_blank" class="goyostats-link-arrow">
                                        <span><?php echo esc_html($referrer->getRawReferrer()) ?></span>
                                    </a>
                                <?php else : ?>
                                    <?php echo Admin_Template::UnknownColumn() // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                <?php endif; ?>
                            </td>

                            <td class="goyostats-pd-l">
                                <div class="goyostats-ellipsis-parent">
                                    <?php if (!empty($referrer->getSourceName())) : ?>
                                        <span class="goyostats-ellipsis-text" title="<?php echo esc_attr($referrer->getSourceName()) ?>"><?php echo esc_html($referrer->getSourceName()) ?></span>
                                    <?php else : ?>
                                        <?php echo Admin_Template::UnknownColumn() // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td class="goyostats-pd-l start">
                                <a href="<?php echo esc_url(Menus::admin_url('referrals', ['tab' => 'referred-visitors', 'referrer' => $referrer->getRawReferrer()])) ?>">
                                    <?php echo esc_html($referrer->getTotalReferrals()) ?>
                                </a>
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
<?php
echo $pagination ?? ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
?>