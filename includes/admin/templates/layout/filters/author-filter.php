<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;

$args = [
    'title' => __('Author', 'goyo-statistics'),
    'type'  => 'author'
];

View::load("components/objects/header-filter-select", $args);
