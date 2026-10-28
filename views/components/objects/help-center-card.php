<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats-help__card">
    <div class="goyostats-help__card-icon">
        <?php echo wp_kses(
            $icon,
            array(
                'svg'  => array(
                    'class'       => true,
                    'xmlns'       => true,
                    'width'       => true,
                    'height'      => true,
                    'viewBox'     => true,
                    'aria-hidden' => true,
                    'role'        => true,
                    'focusable'   => true,
                    'fill'        => true,
                ),
                'path' => array(
                    'd'               => true,
                    'fill'            => true,
                    'stroke'          => true,
                    'stroke-width'    => true,
                    'stroke-linecap'  => true,
                    'stroke-linejoin' => true,
                ),
                'g'    => array(
                    'fill'      => true,
                    'stroke'    => true,
                    'transform' => true,
                ),
            )
        );
        ?>
    </div>
    <span class="goyostats-help__card-category"><?php echo esc_html($category) ?></span>
    <h2 class="goyostats-help__card-title"><?php echo esc_html($title) ?></h2>
    <p class="goyostats-help__card-description"><?php echo esc_html($description); ?></p>
    <?php if (isset($view_more_link)): ?>
        <a href="<?php echo esc_url($view_more_link); ?>" target="_blank" class="goyostats-help__card-link">
            <?php echo esc_html($view_more_title); ?>
        </a>
    <?php endif; ?>
    <?php if (isset($social)): ?>
        <ul class="goyostats-help__card-socials">
            <li><a aria-label="WP Statistics on Linkedin" href="https://www.linkedin.com/showcase/goyo-statistics" target="_blank" class="goyostats-help__card-social goyostats-help__card-social--linkedin"></a></li>
            <li><a aria-label="WP Statistics on Twitter" href="https://x.com/goyo_statistics" target="_blank" class="goyostats-help__card-social goyostats-help__card-social--x"></a></li>
            <li><a aria-label="WP Statistics on Instagram" href="http://instagram.com/veronalabs" target="_blank" class="goyostats-help__card-social goyostats-help__card-social--instagram"></a></li>
            <li><a aria-label="WP Statistics on Github" href="https://github.com/goyo-statistics" target="_blank" class="goyostats-help__card-social goyostats-help__card-social--github"></a></li>
        </ul>
    <?php endif; ?>
</div>