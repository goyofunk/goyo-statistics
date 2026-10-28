<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<button class="<?php echo esc_attr($classes) ?>" aria-label="<?php esc_html_e("Filter", "goyo-statistics") ?>" id="<?php echo esc_attr($filter_type . '-filter'); ?>">
    <span class="dashicons dashicons-filter"></span>
    <span class="goyostats-visitor-filter__text">
        <span class="filter-text"><?php esc_html_e("Filters", "goyo-statistics") ?></span>
        <?php if ($activeFilters > 0) : ?>
            <span class="goyostats-badge"><?php echo esc_html($activeFilters) ?></span>
        <?php endif; ?>
    </span>
</button>
