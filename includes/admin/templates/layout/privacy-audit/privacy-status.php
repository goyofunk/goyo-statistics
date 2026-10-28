<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-privacy-audit__head">
    <span class="goyostats-privacy-audit__status-icon"></span>
    <div class="goyostats-privacy-audit__status-title">
        <span>
            <?php esc_html_e('Privacy Status', 'goyo-statistics'); ?>
        </span>

        <h3>
            <?php if ($isCompliant) : ?>
                <?php esc_html_e('Good', 'goyo-statistics'); ?>
            <?php else : ?>
                <?php esc_html_e('Should be improved', 'goyo-statistics'); ?>
            <?php endif; ?>
        </h3>
    </div>

    <div class="goyostats-privacy-audit__status-description">
        <?php esc_html_e('The Privacy Audit ensures WP Statistics settings comply with privacy standards, offering insights and actionable steps to protect user data.', 'goyo-statistics'); ?>
    </div>

    <div class="goyostats-privacy-audit__status-bar">
        <div class="goyostats-privacy-status loading">
            <div class="goyostats-privacy-status__content">
                <div class="goyostats-privacy-status__percent-container">
                    <div class="goyostats-privacy-status__percent">
                        <span class="goyostats-privacy-status__percent-value"></span><?php esc_html_e('% Ready', 'goyo-statistics'); ?>
                    </div>
                    <div class="goyostats-privacy-status__mapped">
                        <span class="dot"></span> <span class="goyostats-privacy-status__passed-value"></span> <?php esc_html_e('of', 'goyo-statistics'); ?> <span class="goyostats-privacy-status__final-value"></span> <?php esc_html_e('Rules Passed', 'goyo-statistics'); ?>
                    </div>
                </div>
                <div class="goyostats-privacy-status__bars">
                    <div class="goyostats-privacy-status__bar goyostats-privacy-status__bar-passed">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>