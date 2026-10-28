<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-card">
    <div class="goyostats-card__title">
        <h2>
            <?php echo esc_html($title); ?>
            <?php if (isset($tooltip) && $tooltip): ?>
                <span class="goyostats-tooltip" title="<?php echo esc_attr($tooltip); ?>"><i class="goyostats-tooltip-icon info"></i></span>
            <?php endif ?>
        </h2>
    </div>

    <div class="c-goyostats-horizontal-bar__container">
        <canvas id="<?php echo esc_attr($unique_id); ?>" height="0" aria-label="<?php echo esc_html($title); ?> chart" role="img"></canvas>
    </div>
    <?php if (isset($footer_link)): ?>
        <div class="goyostats-card__footer">
            <div class="goyostats-card__footer__more">
                <a class="goyostats-card__footer__more__link" href="<?php echo esc_url($footer_link) ?>">
                    <?php echo esc_html($footer_title) ?>
                </a>
            </div>
        </div>
    <?php endif ?>
</div>