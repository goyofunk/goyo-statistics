<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-notice goyostats-notice--warning">
    <div>
        <p class="goyostats-notice__title"><?php esc_html_e('Some Add-ons Are Missing', 'goyo-statistics'); ?></p>
        <div class="goyostats-notice__description">
            <?php esc_html_e('You have a valid WP Statistics license, but you haven’t installed the following add-ons yet:', 'goyo-statistics') ?>
            <ul>
                <?php foreach ($data['missing_add_ons'] as $addOn): ?>
                    <li>
                        <a href="<?php echo esc_url($addOn->getProductUrl()); ?>?utm_source=goyo-statistics&utm_medium=link&utm_campaign=<?php echo rawurlencode($addOn->getUtmCampaign()); ?>" target="_blank">
                            <?php echo esc_html($addOn->getName()) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php esc_html_e('Install them now to take full advantage of your WP Statistics.', 'goyo-statistics') ?>
        </div>
    </div>
</div>
