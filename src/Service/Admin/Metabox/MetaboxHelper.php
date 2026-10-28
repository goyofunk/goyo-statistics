<?php

namespace Goyo_Statistics\Service\Admin\Metabox;

use Goyo_Statistics\Abstracts\BaseMetabox;
use Goyo_Statistics\Service\Admin\Metabox\Metaboxes\DailyTrafficTrend;
use Goyo_Statistics\Service\Admin\Metabox\Metaboxes\MostVisitedPages;
use Goyo_Statistics\Service\Admin\Metabox\Metaboxes\TrafficOverview;

class MetaboxHelper
{
    public static $metaboxes = [
        \Goyo_Statistics\Service\Admin\Metabox\Metaboxes\EntryPages::class,
        DailyTrafficTrend::class,
        MostVisitedPages::class,
        TrafficOverview::class,
    ];

    /**
     * Retrieves a list of all metaboxes.
     *
     * @return BaseMetabox[]|string[]
     */
    public static function getMetaboxes()
    {
        return apply_filters('goyo_statistics_metabox_list', self::$metaboxes);
    }

    /**
     * Get list of active metaboxes.
     *
     * @return BaseMetabox[]
     */
    public static function getActiveMetaboxes()
    {
        $activeMetaboxes = [];
        $metaboxes = self::getMetaboxes();

        foreach ($metaboxes as $metabox) {
            if (!class_exists($metabox)) continue;

            $metabox = new $metabox();

            if (!$metabox->isActive()) continue;

            $activeMetaboxes[$metabox->getKey()] = $metabox;
        }

        return $activeMetaboxes;
    }

    /**
     * Returns a list of metaboxes which are specific to the current screen grouped by context.
     *
     * @return array
     */
    public static function getScreenMetaboxes()
    {
        $metaboxes = [];

        // Return early if there is no current screen
        if (!function_exists('get_current_screen')) {
            return $metaboxes;
        }

        $currentScreen = get_current_screen()->id;

        // Get screen metaboxes that belong to the current screen
        $screenMetaboxes = [];
        foreach (self::getActiveMetaboxes() as $metabox) {
            if (in_array($currentScreen, $metabox->getScreen()) && !$metabox->isStatic()) {
                $screenMetaboxes[$metabox->getKey()] = $metabox;
            }
        }

        // Get the stored metaboxes for current user
        $userMetaboxes = get_user_meta(get_current_user_id(), "meta-box-order_$currentScreen", true);

        // If there are stored metaboxes, use them
        if (!empty($userMetaboxes)) {
            $contexts = array_keys($userMetaboxes);

            foreach ($contexts as $context) {
                // Get the metaboxes for the current context
                $contextMetaboxes = explode(',', $userMetaboxes[$context]);

                // Remove any non goyo-statistics metaboxes
                $contextMetaboxes = array_filter($contextMetaboxes, function ($metabox) use ($screenMetaboxes) {
                    return strpos($metabox, 'goyo-statistics') !== false && isset($screenMetaboxes[$metabox]);
                });

                if (!empty($contextMetaboxes)) {
                    $metaboxes[$context] = array_values($contextMetaboxes);
                }
            }
        }

        // If there are no stored metaboxes, use the default
        foreach ($screenMetaboxes as $metabox) {
            $key     = $metabox->getKey();
            $context = $metabox->getContext();

            if (!isset($metaboxes[$context]) || !in_array($key, $metaboxes[$context])) {
                $metaboxes[$context][] = $metabox->getKey();
            }
        }

        return $metaboxes;
    }
}