<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
    <div class="inside">
        <?php if (!empty($data)) : ?>
            <div class="o-table-wrapper">
                <table width="100%" class="o-table goyostats-new-table goyostats-recent-events-table">
                    <thead>
                    <tr>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Date', 'goyo-statistics'); ?>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Link URL', 'goyo-statistics'); ?>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Link ID', 'goyo-statistics'); ?>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Link Class', 'goyo-statistics'); ?>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Link Text', 'goyo-statistics'); ?>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Page', 'goyo-statistics') ?>
                        </th>
                        <th scope="col" class="goyostats-pd-l">
                            <?php esc_html_e('Action', 'goyo-statistics') ?>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($data as $author) : ?>
                        <tr>
                            <td class="goyostats-pd-l">March 25, 2024 09:07 PM</td>
                            <td class="goyostats-pd-l">
                                <a target="_blank" href="" title="veronalabs.com/privacy-policy/" class="goyostats-link-arrow">
                                    <span>veronalabs.com/privacy-policy/</span>
                                </a>
                            </td>
                            <td class="goyostats-pd-l">
                                <div class="goyostats-ellipsis-parent">
                                    <span title="footer-nav">footer-nav</span>
                                    <span class="goyostats-ellipsis-text--disable">N/A</span>
                                </div>

                            </td>
                            <td class="goyostats-pd-l">
                                <div class="goyostats-ellipsis-parent">
                                    <span title=".c-footer__social--link">.c-footer__social--link</span>
                                </div>
                            </td>
                            <td class="goyostats-pd-l">
                                <div class="goyostats-ellipsis-parent">
                                    <span title="wp-statistics.com">wp-statistics.com</span>
                                </div>
                            </td>
                            <td class="goyostats-pd-l">
                                <a target="_blank" href="" title="Home Page" class="goyostats-link-arrow">
                                    <span>Home Page</span>
                                </a>
                            </td>
                            <td class="goyostats-pd-l">
                                <div class="goyostats-ellipsis-parent">
                                    <span title="Download">Download</span>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="o-wrap o-wrap--no-data goyostats-center">
                <?php esc_html_e('No recent data available.', 'goyo-statistics') ?>
            </div>
        <?php endif; ?>
    </div>
<?php echo isset($pagination) ? $pagination : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>