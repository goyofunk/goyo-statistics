<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;

$args = [
    'title' => __('Campaign', 'goyo-statistics'),
    'type'  => 'utm_params'
];

View::load("components/objects/header-filter-select", $args);
