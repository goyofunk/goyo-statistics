<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;

$args = [
    'title' => __('Page', 'goyo-statistics'),
    'type'  => 'page'
];

View::load("components/objects/header-filter-select", $args);
