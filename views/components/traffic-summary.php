<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Menus;
?>

<div class="goyostats-card">
    <div class="goyostats-card__title">
        <h2><?php esc_html_e('Traffic Summary', 'goyo-statistics') ?></h2>
    </div>
    <div class="goyostats-meta-traffic-summary">

    <?php if (isset($data['online'])) : ?>
        <div class="c-live">
            <div>
                <span class="c-live__status"></span>
                <span class="c-live__title"><?php esc_html_e('Online Visitors', 'goyo-statistics') ?></span>
            </div>
            <div class="c-live__online">
                <span class="c-live__online--value"><?php echo esc_html($data['online']) ?></span>
                <a class="c-live__value" href="<?php echo esc_url(Menus::admin_url('visitors', ['tab' => 'online'])) ?>" aria-label="<?php esc_attr_e('View online visitors', 'goyo-statistics'); ?>"><span class="c-live__online--arrow"></span></a>
            </div>
        </div>
    <?php endif; ?>

        <div class="o-table-wrapper">
            <table width="100%" class="o-table o-table--goyostats-summary-stats">
                <thead>
                <tr>
                    <th width="50%"><?php esc_html_e('Timeframe', 'goyo-statistics') ?></th>
                    <th><?php esc_html_e('Visitors', 'goyo-statistics') ?></th>
                    <th><?php esc_html_e('Views', 'goyo-statistics') ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['summary'] as $key => $item) :
                        $itemData = $item['data'];
                    ?>
                    <tr>
                        <td>
                            <?php echo esc_html($item['label']); ?>

                            <?php if (isset($item['tooltip'])) : ?>
                                <span class="goyostats-tooltip" title="<?php echo esc_attr($item['tooltip']); ?>"><i class="goyostats-tooltip-icon info"></i></span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <div>
                                <span class="quickstats-values" title="<?php echo esc_attr($itemData['current']['visitors']); ?>"><?php echo esc_html(Helper::formatNumberWithUnit($itemData['current']['visitors'], 1)) ?></span>
                                <?php if (!empty($item['comparison']) && isset($itemData['trend']['visitors']['percentage']) && $itemData['trend']['visitors']['percentage'] !== null) : ?>
                                    <div class="diffs__change <?php echo esc_attr($itemData['trend']['visitors']['direction']); ?>">
                                        <span class="diffs__change__direction"><?php echo esc_html($itemData['trend']['visitors']['percentage']) ?>%</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div>
                                <span class="quickstats-values" title="<?php echo esc_attr($itemData['current']['views']); ?>"><?php echo esc_html(Helper::formatNumberWithUnit($itemData['current']['views'], 1)) ?></span>

                                <?php if (!empty($item['comparison']) && isset($itemData['trend']['views']['percentage']) && $itemData['trend']['views']['percentage'] !== null) : ?>
                                    <div class="diffs__change <?php echo esc_attr($itemData['trend']['views']['direction']); ?>">
                                        <span class="diffs__change__direction"><?php echo esc_html($itemData['trend']['views']['percentage']) ?>%</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
