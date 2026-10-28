<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Admin_Template;
use Goyo_Statistics\Components\View;
use Goyo_Statistics\Decorators\VisitorDecorator;
use GOYO_STATISTICS\Menus;

?>

    <div class="inside">
        <?php if (!empty($data)) : ?>
            <div class="o-table-wrapper">
                <table width="100%" class="o-table goyostats-new-table">
                    <thead>
                    <tr>
                        <th scope="col" class="goyostats-pd-l">
                            <span class="goyostats-order"><?php esc_html_e('Last View', 'goyo-statistics'); ?></span>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Visitor Information', 'goyo-statistics'); ?>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Referrer', 'goyo-statistics'); ?>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <?php echo esc_html__('Current Page', 'goyo-statistics'); ?>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($data as $visitor) : ?>
                        <?php /** @var VisitorDecorator $visitor */ ?>
                        <tr>
                            <td class="goyostats-pd-l"><?php echo esc_html($visitor->getLastView()); ?></td>

                            <td class="goyostats-pd-l">
                                <?php
                                View::load("components/visitor-information", ['visitor' => $visitor]);
                                ?>
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
                                <?php $page = $visitor->getLastPage(); ?>
                                <?php if (!empty($page)) :
                                    View::load("components/objects/internal-link", [
                                        'url'   => $page['report'],
                                        'title' => $page['title'],
                                    ]);
                                else : ?>
                                    <?php echo Admin_Template::UnknownColumn() // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                <?php endif; ?>
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