<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<div class="goyostats--no-data__container" aria-live="polite">
    <?php if(isset($url)):?>
    <img class="goyostats--no-data__image" src="<?php /* translators: %s: string value */ echo esc_url($url) ?>" role="presentation" alt="<?php echo esc_attr(sprintf(__('Illustration for %s', 'goyo-statistics'), $title)) ?>">
    <?php endif ?>
    <p class="<?php echo isset($url) ? 'goyostats--no-data__text'  : 'o-wrap o-wrap--no-data goyostats-center'?>"><?php echo esc_html($title)?></p>
</div>