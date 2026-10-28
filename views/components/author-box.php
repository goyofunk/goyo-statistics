<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Components\View;
?>

<?php if ($show_preview) : ?>
    <div class="disabled goyostats-tooltip-premium">
        <div class="goyostats-tabs-item">
            <div class="goyostats-content-tabs__item--image">
                <span><a href="<?php echo esc_url(Menus::admin_url('author-analytics', ['type' => 'single-author', 'author_id' => esc_html($author_id)])) ?>"> <span class="screen-reader-text"><?php echo esc_html_e('View author analytics', 'goyo-statistics') ?></span></a></span>
                <img src="<?php echo esc_url(get_avatar_url($author_id)); ?>" alt="<?php echo esc_html($author_name); ?>" />
            </div>
            <div class="goyostats-content-tabs__item--content">
                <h3 class="goyostats-ellipsis-parent"><span  class="goyostats-ellipsis-text"><?php echo esc_html($author_name); ?></span></h3>
                <span><span class="goyostats-content-tabs__item--count"><?php echo esc_html(Helper::formatNumberWithUnit($count, 1)); ?></span><?php echo esc_html($count_label) ?></span>
            </div>
        </div>

        <?php
        View::load("components/lock-sections/tooltip-premium", [
            'class'         => 'tooltip-premium--side tooltip-premium--left',
            'addon_name'    => 'goyo-statistics-data-plus',
        ]);
        ?>
    </div>
<?php else: ?>
    <a class="goyostats-tabs-item" href="<?php echo esc_url(Menus::admin_url('author-analytics', ['type' => 'single-author', 'author_id' => esc_html($author_id)])) ?>">
        <div class="goyostats-content-tabs__item--image">
            <span># <?php echo esc_html($counter); ?></span>
            <img src="<?php echo esc_url(get_avatar_url($author_id)); ?>" alt="<?php echo esc_html($author_name); ?>" />
        </div>
        <div class="goyostats-content-tabs__item--content">
            <h3 class="goyostats-ellipsis-parent"><span class="goyostats-ellipsis-text" title="<?php echo esc_html($author_name); ?>"><?php echo esc_html($author_name); ?></span></h3>
            <span><span class="goyostats-content-tabs__item--count"><?php echo esc_html(Helper::formatNumberWithUnit($count, 1)); ?></span><?php echo esc_html($count_label) ?></span>
        </div>
    </a>
<?php endif ?>