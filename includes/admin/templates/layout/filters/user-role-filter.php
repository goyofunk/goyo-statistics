<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;

$args = [
    'title' => __('User Role', 'goyo-statistics'),
    'type'  => 'user-role'
];

View::load("components/objects/header-filter-select", $args);
