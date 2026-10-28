<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Utils\Request;

$authorId = Request::get('author_id', 0, 'number');
$userData = get_userdata($authorId);

$hasUserData = !empty($userData);

$roles    = $hasUserData ? $userData->roles : [];
$userRole = !empty($roles) ? ucfirst($roles[0]) : esc_html__('No role', 'goyo-statistics');

$registeredDate = $hasUserData ? $userData->user_registered : '';
$formattedDate  = $registeredDate ? date_i18n('F j, Y g:i A', strtotime($registeredDate)) : esc_html__('Unknown Date', 'goyo-statistics');

$displayName = $hasUserData ? $userData->display_name : esc_html__('Unknown User', 'goyo-statistics');
$email       = $hasUserData ? $userData->user_email : '';
?>
<div class="goyostats-author-analytics--header">
    <div class="goyostats-author-analytics--header__img">
        <img src="<?php echo esc_url(get_avatar_url($authorId)); ?>" alt="<?php echo esc_html($displayName); ?>">
    </div>
    <div class="goyostats-author-analytics--header__desc">
        <div class="goyostats-author-analytics--header__title">
            <h2 class="goyostats_title" title="<?php echo esc_html($displayName); ?>"><?php echo esc_html($displayName); ?></h2>
            <span><?php echo esc_html($userRole); ?></span>
        </div>
        <div class="goyostats-author-analytics--header__info">
            <span class="goyostats-author-analytics--header__joined"><?php echo esc_html__('Joined on', 'goyo-statistics') ?> <?php echo esc_html($formattedDate); ?></span>
            <?php if ($hasUserData): ?>
                <a href="<?php echo esc_url(get_edit_user_link($authorId)); ?>"><?php echo esc_html__('Visit Profile', 'goyo-statistics') ?></a>
                <a href="<?php echo esc_url(Menus::admin_url('pages', ['tab' => 'top', 'author_id' => $authorId, 'pt' => 'post'])); ?>"><?php echo esc_html__('View Author Posts', 'goyo-statistics') ?></a>
                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html__('Email to Author', 'goyo-statistics') ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>