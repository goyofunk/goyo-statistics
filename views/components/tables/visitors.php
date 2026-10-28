<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Admin_Template;
use Goyo_Statistics\Components\View;
use Goyo_Statistics\Decorators\VisitorDecorator;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Utils\Url;

$linksTarget = !empty($open_links_in_new_tab) ? '_blank' : '';
$viewTitle   = !empty($single_post) ? esc_html__('Page View', 'goyo-statistics') : esc_html__('Last View', 'goyo-statistics')
?>

    <div class="inside">
        <?php if (!empty($data)) : ?>
            <div class="o-table-wrapper">
                <table width="100%" class="o-table goyostats-new-table">
                    <thead>
                    <tr>
                        <th scope="col" class="goyostats-pd-l">
                            <span class="goyostats-order"><?php echo esc_html($viewTitle); ?></span>
                        </th>

                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Visitor Information', 'goyo-statistics'); ?>
                        </th>

                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Referrer', 'goyo-statistics'); ?>
                        </th>

                        <?php if (empty($hide_entry_page_column)) : ?>
                            <th scope="col" class="goyostats-pd-l">
                                <?php echo esc_html__('Entry Page', 'goyo-statistics'); ?>
                            </th>
                        <?php endif; ?>

                        <?php if (empty($hide_latest_page_column)) : ?>
                            <th scope="col" class="goyostats-pd-l">
                                <?php echo isset($page_column_title) ? esc_html($page_column_title) : esc_html__('Exit Page', 'goyo-statistics'); ?>
                            </th>
                        <?php endif; ?>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Total Views', 'goyo-statistics'); ?>
                            <span class="goyostats-tooltip" title="<?php echo esc_html__('Total views for a single day. Privacy rules assign users a new ID daily, so visits on different days are counted separately.', 'goyo-statistics') ?>"><i class="goyostats-tooltip-icon"></i></span>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($data as $visitor) : ?>
                        <?php /** @var VisitorDecorator $visitor */ ?>
                        <tr>
                            <td class="goyostats-pd-l">
                                <?php if (!empty($single_post)) : ?>
                                    <?php echo esc_html($visitor->getPageView()); ?>
                                <?php else : ?>
                                    <?php echo esc_html($visitor->getLastView()); ?>
                                <?php endif; ?>
                            </td>

                            <td class="goyostats-pd-l">
                                <?php View::load("components/visitor-information", ['visitor' => $visitor]); ?>
                            </td>

                            <td class="goyostats-pd-l">
                                <?php
                                View::load("components/objects/referrer-link", [
                                    'label' => $visitor->getReferral()->getSourceChannel(),
                                    'url'   => $visitor->getReferral()->getReferrer(),
                                    'title' => $visitor->getReferral()->getRawReferrer()
                                ]);
                                ?>
                            </td>

                            <?php if (empty($hide_entry_page_column)) : ?>
                                <td class="goyostats-pd-l">
                                    <?php
                                    $page = $visitor->getFirstPage();

                                    if (!empty($page)) :?>
                                        <div class="goyostats-entry-page">
                                            <?php
                                            View::load("components/objects/internal-link", [
                                                'url'     => $page['report'],
                                                'title'   => $page['title'],
                                                'tooltip' => $page['query'] ? "?{$page['query']}" : ''
                                            ]);
                                            ?>

                                            <?php $campaign = sanitize_text_field((string) Url::getParam('?' . $page['query'], 'utm_campaign')); ?>
                                            <?php if ($campaign) : ?>
                                                <span class="goyostats-campaign-label goyostats-tooltip" title="<?php echo esc_attr__('Campaign:', 'goyo-statistics') . ' ' . esc_attr(Helper::plainText($campaign)); ?>"><?php echo esc_html(Helper::plainText($campaign)); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php
                                    else :
                                        echo Admin_Template::UnknownColumn(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    endif;
                                    ?>
                                </td>
                            <?php endif; ?>

                            <?php if (empty($hide_latest_page_column)) : ?>
                                <td class="goyostats-pd-l">
                                    <?php
                                    $page = $visitor->getLastPage();

                                    if (!empty($page)) :
                                        View::load("components/objects/internal-link", [
                                            'url'   => $page['report'],
                                            'title' => $page['title'],
                                        ]);
                                    else :
                                        echo Admin_Template::UnknownColumn(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    endif;
                                    ?>
                                </td>
                            <?php endif; ?>

                            <td class="goyostats-pd-l">
                                <a target="<?php echo esc_attr($linksTarget); ?>" href="<?php echo esc_url(Menus::admin_url('visitors', ['type' => 'single-visitor', 'visitor_id' => $visitor->getId()])) ?>"><?php echo esc_html($visitor->getHits()) ?></a>
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
<?php echo isset($pagination) ? $pagination : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
?>