<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;

$args = [
    'title' => __('Post Type', 'goyo-statistics'),
    'type'  => 'post-type'
];

View::load("components/objects/header-filter-select", $args);
