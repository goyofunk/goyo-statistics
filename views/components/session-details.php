<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use GOYO_STATISTICS\Admin_Template;
use Goyo_Statistics\Decorators\VisitorDecorator;
use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Components\View;
?>

<?php /** @var VisitorDecorator $visitor */ ?>

<div class="goyostats-visitor__visitors-details">
    <div class="goyostats-visitor__visitors-detail--row">
        <?php if ($visitor->isHashedIP()) : ?>
            <span>
                <?php esc_html_e('Visitor Hash', 'goyo-statistics'); ?>
            </span>
        <?php else : ?>
            <span>
                <?php esc_html_e('IP Address', 'goyo-statistics'); ?>
            </span>
        <?php endif; ?>

        <div>
            <span title="<?php echo esc_attr($visitor->getIP()); ?>"><?php echo esc_html($visitor->getIP()); ?></span>
        </div>
    </div>

    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('Referrer', 'goyo-statistics'); ?></span>
        <div class="goyostats-visitor__visitors-detail--link goyostats-ellipsis-parent">
            <?php if (!empty($visitor->getReferral()->getReferrer())) :
                View::load("components/objects/external-link", ['url' => $visitor->getReferral()->getReferrer(), 'title' => $visitor->getReferral()->getRawReferrer()]);
            else : ?>
                <?php echo Admin_Template::UnknownColumn() // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('Source Category', 'goyo-statistics'); ?></span>
        <div class="goyostats-visitor__visitors-detail--link goyostats-ellipsis-parent">
            <?php if (!empty($visitor->getReferral()->getSourceChannel())) : ?>
                <span><?php echo esc_html($visitor->getReferral()->getSourceChannel()) ?></span>
            <?php else : ?>
                <?php echo Admin_Template::UnknownColumn() // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('Browser', 'goyo-statistics'); ?></span>
        <div class="goyostats-browsers__flag">
            <a href="<?php echo esc_url(Menus::admin_url('visitors', ['tab' => 'visitors','agent' => $visitor->getBrowser()->getRaw()])) ?>"><img src="<?php echo esc_url($visitor->getBrowser()->getLogo()); ?>" alt="<?php echo esc_attr($visitor->getBrowser()->getName()) ?>" width="15" height="15"></a>

            <?php if ($visitor->getBrowser()->getName() !== 'Unknown') : ?>
                <span title="<?php echo esc_attr("{$visitor->getBrowser()->getName()} v{$visitor->getBrowser()->getVersion()}") ?>"><?php echo esc_html("{$visitor->getBrowser()->getName()} v{$visitor->getBrowser()->getVersion()}") ?></span>
            <?php else : ?>
                <span title="<?php echo esc_attr($visitor->getBrowser()->getName()) ?>"><?php echo esc_html($visitor->getBrowser()->getName()) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('Operating System', 'goyo-statistics'); ?></span>
        <div class="goyostats-os__flag">
            <a href="<?php echo esc_url(Menus::admin_url('visitors', ['tab' => 'visitors','platform' => $visitor->getOs()->getName()])) ?>"><img src="<?php echo esc_url($visitor->getOs()->getLogo()) ?>" alt="<?php echo esc_attr($visitor->getOs()->getName()) ?>" width="15" height="15"></a>
            <span title="<?php echo esc_attr($visitor->getOs()->getName()) ?>"><?php echo esc_html($visitor->getOs()->getName()) ?></span>
        </div>
    </div>

    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('Country', 'goyo-statistics'); ?></span>
        <div class="goyostats-country__flag">
            <a href="<?php echo esc_url(Menus::admin_url('geographic', ['type' => 'single-country', 'country' => $visitor->getLocation()->getCountryCode()])) ?>" class="goyostats-country__flag">
                <img src="<?php echo esc_url($visitor->getLocation()->getCountryFlag()) ?>" alt="<?php echo esc_attr($visitor->getLocation()->getCountryName()) ?>" width="19" height="15">
            </a>
            <span title="<?php echo esc_attr($visitor->getLocation()->getCountryName()) ?>"><?php echo esc_html($visitor->getLocation()->getCountryName()) ?></span>
        </div>
    </div>

    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('City', 'goyo-statistics'); ?></span>
        <div class="goyostats-ellipsis-parent">
            <span title="<?php echo esc_attr(Admin_Template::unknownToNotSet($visitor->getLocation()->getCity())) ?>"><?php echo esc_html(Admin_Template::unknownToNotSet($visitor->getLocation()->getCity())) ?></span>
        </div>
    </div>

    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('Region', 'goyo-statistics'); ?></span>
        <div class="goyostats-ellipsis-parent">
            <span title="<?php echo esc_attr(Admin_Template::unknownToNotSet($visitor->getLocation()->getRegion())) ?>"><?php echo esc_html(Admin_Template::unknownToNotSet($visitor->getLocation()->getRegion())) ?></span>
        </div>
    </div>

    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('First View', 'goyo-statistics'); ?>&nbsp;</span>
        <div class="goyostats-ellipsis-parent">
            <span><?php echo esc_html($visitor->getFirstView() ?? $visitor->getLastCounter()) ?></span>
        </div>
    </div>

    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('Entry Page', 'goyo-statistics'); ?></span>
        <div>
            <?php
            $page = $visitor->getFirstPage();

            if (!empty($page)) :
                View::load("components/objects/internal-link", [
                    'url'     => $page['report'],
                    'title'   => $page['title'],
                    'tooltip' => $page['query'] ? "?{$page['query']}" : ''
                ]) ;
            else :
                echo Admin_Template::UnknownColumn(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            endif;
            ?>
        </div>
    </div>

    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('Exit Page', 'goyo-statistics'); ?>&nbsp;</span>
        <div>
            <?php
            $page = $visitor->getLastPage();

            if (!empty($page)) :
                View::load("components/objects/internal-link", [
                    'url'     => $page['report'],
                    'title'   => $page['title']
                ]);
            else :
                echo Admin_Template::UnknownColumn(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            endif;
            ?>
        </div>
    </div>

    <div class="goyostats-visitor__visitors-detail--row">
        <span><?php esc_html_e('Total Views', 'goyo-statistics'); ?> <span class="goyostats-tooltip" title="<?php esc_html_e('Total views for a single day. Privacy rules assign users a new ID daily, so visits on different days are counted separately.', 'goyo-statistics'); ?>"><i class="goyostats-tooltip-icon"></i></span></span>
        <div>
            <span><?php echo esc_html($visitor->getHits()) ?></span>
        </div>
    </div>
</div>