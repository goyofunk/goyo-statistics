<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Utils\Request;
$uri = Request::get('uri', '', 'raw');
$uri = rawurldecode($uri);
?>

<div class="goyostats-content-analytics-header goyostats-content-analytics-header__single-resource">
    <div>
        <div class="goyostats-content-analytics-header__title">
            <h2 class="goyostats_title"><?php echo esc_html($uri); ?></h2>
            <a href="<?php echo esc_url(home_url($uri)); ?>" target="_blank" title="<?php echo esc_attr($uri); ?>"></a>
        </div>
    </div>
</div>