<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-audit-cards goyostats-privacy-questions">
    <h2 class="goyostats-audit-cards__title goyostats-audit-cards__title--dark">
        <?php esc_html_e('FAQS', 'goyo-statistics'); ?>
    </h2>
    <div class="goyostats-audit-cards__container loading">
        <!-- load faq items using js -->
    </div>
</div>
<div class="goyostats-privacy-audit__links">
    <h3><?php esc_html_e('Useful Privacy Resources and References', 'goyo-statistics'); ?></h3>
    <ul>
        <li>
            <?php echo wp_kses_post(__('<a href="'. esc_url(GOYO_STATISTICS_SITE_URL . '/resources/avoiding-pii-data-collection/?utm_source=goyo-statistics&utm_medium=link&utm_campaign=privacy').'" target="blank">Configuring for Maximum Privacy: A Guide to Avoiding PII Data Collection</a>', 'goyo-statistics')); ?>
        </li>
        <li>
            <?php echo wp_kses_post(__('<a href="'. esc_url(GOYO_STATISTICS_SITE_URL . '/resources/what-we-collect/?utm_source=goyo-statistics&utm_medium=link&utm_campaign=privacy').'" target="blank">GDPR, CCPA and cookie law compliant site analytics</a>', 'goyo-statistics')); ?>
        </li>
        <li>
            <?php echo wp_kses_post(__('<a href="'. esc_url(GOYO_STATISTICS_SITE_URL . '/resources/counting-unique-visitors-without-cookies/?utm_source=goyo-statistics&utm_medium=link&utm_campaign=privacy').'" target="blank">Counting Unique Visitors Without Cookies</a>', 'goyo-statistics')); ?>
        </li>
        <li>
            <?php echo wp_kses_post(__('<a href="'. esc_url(GOYO_STATISTICS_SITE_URL . '/resources/compliant-with-wordpress-data-export-and-erasure/?utm_source=goyo-statistics&utm_medium=link&utm_campaign=privacy').'" target="blank">Compliant with WordPress Data Export and Erasure</a>', 'goyo-statistics')); ?>
        </li>
        <li>
            <?php echo wp_kses_post(__('<a href="'. esc_url(GOYO_STATISTICS_SITE_URL . '/resources/wp-consent-level-integration/?utm_source=goyo-statistics&utm_medium=link&utm_campaign=privacy').'" target="blank">WP Consent Level Integration</a>', 'goyo-statistics')); ?>
        </li>
    </ul>
</div>