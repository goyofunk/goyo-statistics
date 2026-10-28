<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-notification-sidebar__card <?php echo esc_attr($notification->backgroundColor()); ?> goyostats-notification-<?php echo esc_attr($notification->getID()) ?>">
    <?php if ($notification->getIcon()): ?>
        <div class="goyostats-notification-sidebar__card-icon">
            <span><?php echo esc_html($notification->getIcon()); ?></span>
        </div>
    <?php endif; ?>
    <div class="goyostats-notification-sidebar__card-body">
        <div class="goyostats-notification-sidebar__card-title">
            <?php if ($notification->getTitle()): ?>
                <div><?php echo esc_html($notification->getTitle()) ?></div>
            <?php endif; ?>
            <?php if ($notification->activatedAt()): ?>
                <div class="goyostats-notification-sidebar__card-date"><?php echo esc_html($notification->activatedAt()) ?></div>
            <?php endif; ?>
        </div>
        <?php if ($notification->getDescription()): ?>
            <div class="goyostats-notification-sidebar__card-content">
                <?php echo $notification->getDescription() ?>
            </div>
        <?php endif; ?>
        <div class="goyostats-notification-sidebar__card-actions">
            <?php if ($notification->primaryButtonTitle() && $notification->primaryButtonUrl()): ?>
                <a href="<?php echo esc_url($notification->primaryButtonUrl()); ?>" class="goyostats-notification-sidebar__button" target="_blank">
                    <?php echo esc_html($notification->primaryButtonTitle()); ?>
                </a>
            <?php endif; ?>
            <?php if ($notification->secondaryButtonTitle() && $notification->secondaryButtonUrl()): ?>
                <a href="<?php echo esc_url($notification->secondaryButtonUrl()); ?>" class="goyostats-notification-sidebar__button" target="_blank">
                    <?php echo esc_html($notification->secondaryButtonTitle()); ?>
                </a>
            <?php endif; ?>
            <?php if (!$notification->getDismiss()): ?>
                <a href="#" class="goyostats-notification-sidebar__dismiss" data-notification-id="<?php echo esc_attr($notification->getID()); ?>">
                    <?php echo esc_html__('Dismiss', 'goyo-statistics'); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>