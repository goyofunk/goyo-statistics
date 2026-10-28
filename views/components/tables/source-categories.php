<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

$source_colors = [
    '#4285F4',
    '#9C27B0',
    '#34A853',
    '#FBBC05',
    '#9E9E9E',
];
?>
<div class="inside">
    <?php if (!empty($data)): ?>
        <div class="o-table-wrapper goyostats-source-category">
            <table class="o-table goyostats-new-table goyostats-source-category__table">
                <thead>
                <tr>
                    <th scope="col" class="goyostats-pd-l"><?php echo esc_html_e('Source Category', 'goyo-statistics') ?></th>
                    <th scope="col" class="goyostats-pd-l"><?php echo esc_html_e('Top Domain', 'goyo-statistics') ?></th>
                    <th scope="col" class="goyostats-pd-l"><?php echo esc_html_e('Visitors', 'goyo-statistics') ?></th>
                    <th scope="col" class="goyostats-pd-l">%</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $index => $row):
                    $color = $source_colors[$index] ?? '#4285F4'; // default color
                    ?>
                    <tr>
                        <td class="goyostats-pd-l">
                            <div class="goyostats-source-category__bg" style="border-color:<?php echo $color; ?>;color: <?php echo $color; ?>;"></div>
                            <span><?php echo esc_html($row['source_category']); ?></span>
                            <p class="goyostats-ellipsis-parent <?php echo ($row['top_domain'] === '-') ? 'goyostats-hidden' : ''; ?>" title="<?php echo esc_attr($row['top_domain']); ?>">
                                <span class="goyostats-ellipsis-text"><?php echo esc_html($row['top_domain']); ?></span>
                            </p>
                        </td>
                        <td class="goyostats-pd-l"><span><?php echo esc_html($row['top_domain']); ?></span></td>
                        <td class="goyostats-pd-l"><span><?php echo esc_html($row['visitors']); ?></span></td>
                        <td class="goyostats-pd-l"><span><?php echo esc_html($row['percentage']); ?></span></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="o-wrap o-wrap--no-data goyostats-center">
            <?php esc_html_e('No recent data available.', 'goyo-statistics') ?>
        </div>
    <?php endif; ?>
</div>
