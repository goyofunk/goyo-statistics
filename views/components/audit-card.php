<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-audit-card goyostats-audit-card--<?php echo esc_html($status)?>">
    <div class="goyostats-audit-card__header">
        <div class="goyostats-audit-card__top">
            <div class="goyostats-audit-card__details">
                <div class="goyostats-audit-card__icon"><?php echo $svg ?></div>
                <div>
                    <h3 class="goyostats-audit-card__title"><?php echo esc_html($title) ?></h3>
                    <?php if (isset($description)) : ?>
                        <p class="goyostats-audit-card__summary"><?php echo esc_html($description) ?></p>
                    <?php endif; ?>
                </div>

            </div>
            <div class="goyostats-audit-card__status">
                <span class="goyostats-audit-card__status-indicator"></span>
                <?php if (($status === 'danger') || ($status === 'warning')) : ?>
                    <span class="goyostats-audit-card__status-text"> <?php echo $status === 'danger' ? esc_html__('Attention Needed', 'goyo-statistics'): esc_html__('Warning', 'goyo-statistics') ?> </span>
                <?php endif; ?>

                <button aria-label="Toggle audit details" class="goyostats-audit-card__toggle" aria-expanded="false"></button>
            </div>

        </div>

    </div>
    <div class="goyostats-audit-card__body">
        <div class="goyostats-audit-card__content-text"><?php echo $content ?></div>
        <?php if (isset($suggestion)) : ?>
            <div class="goyostats-audit-card__suggestion">
                <div class="goyostats-audit-card__suggestion-head">
                    <?php echo esc_html__('Suggestion', 'goyo-statistics') ?>
                </div>
                <p class="goyostats-audit-card__suggestion-text"><?php echo $suggestion ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
