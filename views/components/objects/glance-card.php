<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-card">
    <div class="goyostats-card__title">
        <h2><?php esc_html_e('At a Glance', 'goyo-statistics'); ?></h2>
    </div>
    <div class="inside">
        <div class="goyostats-at-a-glance <?php echo isset($two_column) && $two_column ? 'goyostats-at-a-glance__two-col' : ''; ?>">
            <?php if (!empty($metrics) && is_array($metrics)): ?>
                <?php foreach ($metrics as $metric): ?>
                    <div class="goyostats-at-a-glance-item">
                        <!-- Metric Label -->
                        <span class="goyostats-at-a-glance-label" title="<?php echo esc_html($metric['label'] ?? ''); ?>">
                               <?php if (!empty($metric['icon'])): ?>
                                   <i class="goyostats-at-a-glance-icon <?php echo esc_attr($metric['icon']); ?>" aria-hidden="true" aria-label="<?php echo esc_attr($metric['label']); ?>"></i>
                               <?php endif; ?>
                            <?php if (!empty($metric['link-href'])): ?>
                                <a href="<?php echo esc_url($metric['link-href']); ?>"
                                   title="<?php echo esc_attr($metric['label']); ?>">
                                    <?php echo esc_html($metric['label'] ?? ''); ?>
                                </a>
                            <?php else: ?>
                                <?php echo esc_html($metric['label'] ?? ''); ?>
                            <?php endif; ?>
                            <?php if (!empty($metric['tooltip'])): ?>
                                <span class="goyostats-tooltip" title="<?php echo esc_html($metric['tooltip']); ?>">
                                    <i class="goyostats-tooltip-icon info"></i>
                                </span>
                            <?php endif; ?>
                        </span>
                        <span class="goyostats-at-a-glance-value<?php echo !empty($metric['link-href']) && !empty($metric['link-title']) ? ' goyostats-at-a-glance-link' : ''; ?>">
                            <?php if (!empty($metric['link-href']) && !empty($metric['link-title'])): ?>
                                <a href="<?php echo esc_url($metric['link-href']); ?>" title="<?php echo esc_html($metric['link-title'] ?? 'View Details'); ?>" target="_blank" class="goyostats-external-link">
                                    <?php echo esc_html($metric['link-title'] ?? 'View Details'); ?>
                                </a>


                            <?php elseif (isset($metric['score'])): ?>
                                <span title="<?php echo esc_html($metric['score']); ?>" class="goyostats-at-a-glance-score">
                                    <?php echo esc_html($metric['score']); ?><span> /100</span>
                                </span>

                            <?php elseif (isset($metric['value'])): ?>
                                <span title="<?php echo esc_html($metric['value'] ?? 'No data'); ?>">
                                    <?php if ($metric['value']): ?>
                                        <?php echo esc_html($metric['value']); ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </span>
                            <?php else: ?>
                                <span>-</span>
                            <?php endif; ?>
                            <?php if (isset($metric['change']) && $metric['change'] !== null && (!empty($metric['link-title']) || !empty($metric['value']))): ?>
                                <?php
                                $arrow_class = $metric['change'] > 0 ? 'goyostats-glance-up' : ($metric['change'] < 0 ? 'goyostats-glance-down' : '');
                                $color_class = '';
                                if ($metric['change'] != 0) {
                                    $is_negative_polarity = isset($metric['polarity']) && $metric['polarity'] === 'negative';
                                    $is_good_change = ($is_negative_polarity && $metric['change'] < 0) || (!$is_negative_polarity && $metric['change'] > 0);
                                    $color_class = $is_good_change ? 'goyostats-glance-positive' : 'goyostats-glance-negative';
                                }
                                $changeValue = number_format(abs((float) $metric['change']), 1);
                                ?>
                                <span class="goyostats-at-a-glance-change <?php echo esc_attr($arrow_class . ' ' . $color_class); ?>">
                                    <?php echo esc_html($changeValue) . '%'; ?>
                                </span>
                            <?php endif; ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p><?php esc_html_e('No metrics available.', 'goyo-statistics'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>