<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Pages;
use Goyo_Statistics\Components\View;
?>
<?php if (!empty($data)) : ?>
    <div class="o-table-wrapper">
        <table width="100%" class="o-table goyostats-new-table goyostats-table-inspect goyostats-new-table__most-visited">
            <thead>
            <tr>
                <th scope="col" class="goyostats-pd-l"><?php esc_html_e('Page', 'goyo-statistics'); ?></th>
                <th scope="col" class="goyostats-pd-l"><span class="goyostats-order"><?php esc_html_e('Views', 'goyo-statistics'); ?></span></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($data as $item) : ?>
                <?php
                    $page       = Pages::get_page_info($item->id, $item->type, $item->uri);

                ?>
                <tr>
                    <td class="goyostats-pd-l">
                        <a title="<?php echo esc_attr($page['title']) ?>" class="goyostats-table-ellipsis--name" href="<?php echo esc_url($page['link']) ?>"><span><?php echo esc_html($page['title']) ?></span></a>
                    </td>

                    <td class="goyostats-pd-l">
                        <span><?php echo esc_html(number_format_i18n($item->views)) ?></span>
                    </td>

                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <?php
    $title = __('No data found for this date range.', 'goyo-statistics');
    if ($isTodayOrFutureDate) {
        $title = __('Data coming soon!', 'goyo-statistics');
    }
    View::load("components/objects/no-data", [
        'title' => $title
    ]);
    ?>
<?php endif; ?>
