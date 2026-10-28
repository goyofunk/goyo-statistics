<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Decorators\UserDecorator;

?>

<?php /** @var UserDecorator $user */ ?>
<div class="goyostats-visitor__visitors-details">
    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('Username', 'goyo-statistics'); ?></span>
        <div>
            <a href="<?php echo esc_url(get_edit_user_link($user->getId())); ?>" class="goyostats-visitor__username">
                <img src="<?php echo esc_url(GOYO_STATISTICS_URL . 'assets/images/user-icon.svg'); ?>" width="19" height="19" alt="<?php echo esc_attr(sprintf('%s (#%s)', $user->getDisplayName(), $user->getId())); ?>">
                <span class="goyostats-link-color"><?php echo esc_html(sprintf('%s (#%s)', $user->getDisplayName(), $user->getId())); ?></span>
            </a>
        </div>
    </div>

    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('Email address', 'goyo-statistics'); ?></span>
        <div>
            <a href="mailto:<?php echo esc_attr($user->getEmail()); ?>" title="<?php echo esc_attr($user->getEmail()); ?>">
                <span class="goyostats-link-color"><?php echo esc_html($user->getEmail()); ?></span>
            </a>
        </div>
    </div>

    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('Last login', 'goyo-statistics'); ?></span>
        <div class="goyostats-ellipsis-parent">
            <span><?php echo $user->getLastLogin() ? esc_html($user->getLastLogin()) : esc_html('-'); ?></span>
        </div>
    </div>

    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('Registered', 'goyo-statistics'); ?></span>
        <div class="goyostats-ellipsis-parent">
            <span><?php echo esc_html($user->getRegisteredDate()); ?></span>
        </div>
    </div>

    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('Role', 'goyo-statistics'); ?></span>
        <div class="goyostats-ellipsis-parent">
            <span class="c-capitalize"><?php echo esc_html($user->getRole()); ?></span>
        </div>
    </div>
</div>