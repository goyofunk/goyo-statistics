<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;
use Goyo_Statistics\Utils\Request;

$activeFilters = Request::has('referrer');

$classes[] = 'goyostats-modal-filter';
$classes[] = $activeFilters ? 'wp-modal-filter--active' : '';
$classes[] = is_rtl() ? 'goyostats-pull-left' : 'goyostats-pull-right';

$args = [
    'filter_type'   => 'goyostats-modal',
    'classes'       => implode(' ', $classes),
    'activeFilters' => $activeFilters,
];

View::load("components/objects/header-filter-button", $args);
?>