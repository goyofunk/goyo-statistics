<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;

?>
<div class="goyostats-notification-sidebar">
    <div class="goyostats-notification-sidebar__menu">
        <div class="goyostats-notification-sidebar__header">
            <div>
                <h2 class="goyostats-notification-sidebar__title"><?php esc_html_e('Notifications', 'goyo-statistics'); ?></h2>
                <span class="goyostats-notification-sidebar__close"></span>
            </div>
            <div>
                <ul class="goyostats-notification-sidebar__tabs">
                    <li class="goyostats-notification-sidebar__tab goyostats-notification-sidebar__tab--active"
                        data-tab="tab-1"><?php esc_html_e('Inbox', 'goyo-statistics'); ?></li>
                    <li class="goyostats-notification-sidebar__tab"
                        data-tab="tab-2"><?php esc_html_e('Dismissed', 'goyo-statistics'); ?></li>
                </ul>

                <?php if (!empty($notifications)) : ?>
                    <?php
                    $hasNotifications = false;
                    foreach ($notifications as $notification) {
                        if (!$notification->getDismiss()) {
                            $hasNotifications = true;
                            break;
                        }
                    }
                    ?>
                    <?php if ($hasNotifications) : ?>
                        <a href="#"
                           class="goyostats-notification-sidebar__dismiss-all"><?php esc_html_e('Dismiss all', 'goyo-statistics'); ?></a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="goyostats-notification-sidebar__content">
            <div class="goyostats-notification-sidebar__tab-pane goyostats-notification-sidebar__tab-pane--active" id="tab-1">
                <div class="goyostats-notification-sidebar__cards goyostats-notification-sidebar__cards--active">
                    <?php
                    $hasNotifications = false;
                    if (!empty($notifications)) :
                        foreach ($notifications as $notification) :
                            if ($notification->getDismiss()) continue;
                            $hasNotifications = true;
                            View::load("components/notification/card", ['notification' => $notification]);
                        endforeach;
                        View::load("components/notification/no-data", ['tab' => __('inbox', 'goyo-statistics')]);
                    endif;
                    if (!$hasNotifications) {
                        View::load("components/notification/no-data", ['tab' => __('inbox', 'goyo-statistics')]);
                    }
                    ?>
                </div>
            </div>
            <div class="goyostats-notification-sidebar__tab-pane" id="tab-2">
                <div class="goyostats-notification-sidebar__cards goyostats-notification-sidebar__cards--dismissed">
                    <?php
                    $hasDismissed = false;
                    if (!empty($notifications)) :
                        foreach ($notifications as $notification) :
                            if (!$notification->getDismiss()) continue;
                            $hasDismissed = true;
                            View::load("components/notification/card", ['notification' => $notification]);
                        endforeach;
                        View::load("components/notification/no-data", ['tab' => __('dismissed list', 'goyo-statistics')]);
                    endif;
                    if (!$hasDismissed) {
                        View::load("components/notification/no-data", ['tab' => __('dismissed list', 'goyo-statistics')]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="goyostats-notification-sidebar__overlay"></div>
</div>