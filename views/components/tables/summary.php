<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-card">
    <div class="goyostats-card__title">
        <h2>
            <?php echo esc_html($title) ?>
            <?php if ($tooltip): ?>
                <span class="goyostats-tooltip" title="<?php echo esc_attr($tooltip); ?>"><i class="goyostats-tooltip-icon info"></i></span>
            <?php endif ?>
        </h2>
    </div>
    <div class="inside">
        <?php if (!empty($data)) : ?>
            <div class="o-table-wrapper">
                <table width="100%" class="o-table goyostats-new-table">
                    <thead>
                    <tr>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Time', 'goyo-statistics'); ?>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Visitors', 'goyo-statistics'); ?>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Views', 'goyo-statistics'); ?>&nbsp;
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($data as $item) : ?>
                        <tr>
                            <td class="goyostats-pd-l"><?php echo esc_html($item['label']) ?></td>
                            <td class="goyostats-pd-l"><?php echo esc_html(number_format_i18n($item['visitors'])) ?></td>
                            <td class="goyostats-pd-l"><?php echo esc_html(number_format_i18n($item['views'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="o-wrap o-wrap--no-data goyostats-center">
                <?php esc_html_e('No recent data available.', 'goyo-statistics')   ?>
            </div>
        <?php endif; ?>
    </div>

</div>