<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Admin_Template;
use Goyo_Statistics\Components\View;
use Goyo_Statistics\Decorators\VisitorDecorator;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Utils\Url;

?>
<?php if (!empty($data)) : ?>
    <div class="o-table-wrapper">
        <table width="100%" class="o-table goyostats-new-table">
            <thead>
            <tr>
                <th class="goyostats-pd-l">
                    <span class="goyostats-order"><?php esc_html_e('Views', 'goyo-statistics'); ?></span>
                </th>
                <th class="goyostats-pd-l">
                    <?php esc_html_e('Visitor Info', 'goyo-statistics'); ?>
                </th>
                <th class="goyostats-pd-l">
                    <?php esc_html_e('Referrer', 'goyo-statistics'); ?>
                </th>
                <th class="goyostats-pd-l">
                    <?php esc_html_e('Entry Page', 'goyo-statistics'); ?>
                </th>
                <th class="goyostats-pd-l">
                    <?php esc_html_e('Exit Page', 'goyo-statistics'); ?>
                </th>
                <th class="goyostats-pd-l">
                    <?php esc_html_e('Last View', 'goyo-statistics'); ?>
                </th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($data as $visitor) : ?>
                <?php /** @var VisitorDecorator $visitor */ ?>

                <tr>
                    <td class="goyostats-pd-l">
                        <a href="<?php echo esc_url(Menus::admin_url('visitors', ['type' => 'single-visitor', 'visitor_id' => $visitor->getId()])) ?>"><?php echo esc_html($visitor->getHits()) ?></a>
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

                    <td class="goyostats-pd-l">
                        <?php
                        $firstPage = $visitor->getFirstPage();

                        if (!empty($firstPage)) :?>
                            <div class="goyostats-entry-page">
                                <?php
                                View::load("components/objects/internal-link", [
                                    'url'     => $firstPage['report'],
                                    'title'   => $firstPage['title'],
                                    'tooltip' => $firstPage['query'] ? "?{$firstPage['query']}" : ''
                                ]);
                                ?>

                                <?php $campaign = sanitize_text_field((string) Url::getParam('?' . $firstPage['query'], 'utm_campaign')); ?>
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


                    <td class="goyostats-pd-l">
                        <?php
                        $lastPage = $visitor->getLastPage();

                        if (!empty($lastPage)) :
                            View::load("components/objects/internal-link", [
                                'url'   => $lastPage['report'],
                                'title' => $lastPage['title'],
                            ]);
                        else :
                            echo Admin_Template::UnknownColumn(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        endif;
                        ?>
                    </td>

                    <td class="goyostats-pd-l">
                        <?php echo esc_html($visitor->getLastView()) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <?php
    $title = esc_html__('No data found for this date range.', 'goyo-statistics');
    if ($isTodayOrFutureDate) {
        $title = esc_html__('Data coming soon!', 'goyo-statistics');
    }
    View::load("components/objects/no-data", [
        'title' => $title
    ]);
    ?>
<?php endif; ?>