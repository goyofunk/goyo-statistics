<?php

namespace Goyo_Statistics\Service\Admin\Notification;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\Event;
use GOYO_STATISTICS\Option;

class NotificationManager
{
    /**
     * NotificationManager constructor.
     *
     * Initializes hooks for AJAX callbacks, cron schedules,
     * and schedules the notification fetch event.
     */
    public function __construct()
    {
        if (Option::get('display_notifications')) {
            add_action('admin_init', [$this, 'registerActions']);
        }
    }

    /**
     * Registers notification actions.
     *
     * @return void
     */
    public function registerActions()
    {
        $notificationActions = new NotificationActions();

        $notificationActions->register();
    }
}