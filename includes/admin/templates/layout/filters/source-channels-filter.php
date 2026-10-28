<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;

$args = [
    'title' => __('Source Category', 'goyo-statistics'),
    'type'  => 'source-channels'
];

View::load("components/objects/header-filter-select", $args);
