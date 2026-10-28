<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;
use GOYO_STATISTICS\Helper;
use GOYO_STATISTICS\Visitor;

?>

<div class="inside">
    <?php if (!empty($data)) : ?>
        <div class="o-table-wrapper">
            <table width="100%" class="o-table goyostats-new-table goyostats-table-inspect">
                <thead>
                <tr>
                    <th class="goyostats-pd-l">
                        <?php esc_html_e('Entry Page', 'goyo-statistics') ?>
                    </th>
                    <th class="goyostats-pd-l">
                        <?php esc_html_e('Unique Entrances', 'goyo-statistics') ?>
                    </th>
                    <th class="goyostats-pd-l">
                        <?php esc_html_e('Bounce Rate', 'goyo-statistics') ?>
                    </th>
                    <th class="goyostats-pd-l"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $page) :
                    $pageInfo = Visitor::get_page_by_id($page->page_id);
                    ?>
                    <tr>
                        <td class="goyostats-pd-l">
                            <?php View::load("components/objects/internal-link", [
                                'url'   => $pageInfo['report'],
                                'title' => $pageInfo['title']
                            ]); ?>
                        </td>

                        <td class="goyostats-pd-l">
                            <span><?php echo esc_html(number_format_i18n($page->visitors)); ?></span>
                        </td>

                        <td class="goyostats-pd-l">
                            <span><?php echo esc_html(round((float) ($page->bounce_rate ?? 0), 1) . '%'); ?></span>
                        </td>

                        <td class="goyostats-pd-l view-more view-more__arrow">
                            <a target="_blank" href="<?php echo esc_url($pageInfo['link']) ?>"><?php esc_html_e('View Page', 'goyo-statistics') ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="o-wrap o-wrap--no-data goyostats-center">
            <?php echo esc_html(Helper::getNoDataMessage()); ?>
        </div>
    <?php endif; ?>
</div>