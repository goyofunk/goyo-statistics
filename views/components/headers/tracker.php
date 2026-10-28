<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Utils\Url;
use Goyo_Statistics\Utils\Request;

if (Menus::in_page('download_tracker')) {
    $title   = __('Download Report', 'goyo-statistics');
} elseif (Menus::in_page('link_tracker')) {
    $title   = __('Link Report', 'goyo-statistics');
}
?>

<div class="goyostats-tracker-header">
    <div>
        <div class="goyostats-tracker-header__title">

            <h1 class="goyostats_title">
                <?php echo esc_html($title) ?>
            </h1>
        </div>
        <div class="goyostats-tracker-header__info">
            <?php
                $target     = Request::get('target');
                $filename   = basename(Url::getPath($target));
                $url        = preg_replace('#(?<!:)/{2,}#', '/', str_replace($filename, '', $target));
            ?>
            <a href="<?php echo esc_url($target) ?>" title="<?php echo esc_html($target) ?>" target="_blank">
                <span><?php echo esc_html($url) ?></span><span><?php echo esc_html($filename) ?></span>
            </a>
        </div>
    </div>
</div>