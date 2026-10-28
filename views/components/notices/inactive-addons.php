<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-notice goyostats-notice--warning">
    <div>
        <p class="goyostats-notice__title"><?php esc_html_e('Inactive Add-ons', 'goyo-statistics'); ?></p>
        <div class="goyostats-notice__description">
            <?php esc_html_e('You’ve installed the following WP Statistics add-ons, but they’re currently inactive:', 'goyo-statistics'); ?>
            <ul>
                <?php foreach ($data['inactive_installed_add_ons'] as $addOn): ?>
                    <li>
                        <a href="<?php echo esc_url($addOn->getProductUrl()); ?>?utm_source=goyo-statistics&utm_medium=link&utm_campaign=<?php echo rawurlencode($addOn->getUtmCampaign()); ?>" target="_blank">
                            <?php echo esc_html($addOn->getName()) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php esc_html_e('Activate them now to unlock their features and get the most out of WP Statistics.', 'goyo-statistics'); ?>
        </div>
    </div>
</div>
