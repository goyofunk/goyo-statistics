<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\View;

$activeFilters = 0;

foreach ($_GET as $params_key => $params_item) {
    if (! empty($params_item) && in_array($params_key, ['author_id', 'url'])) {
        $activeFilters++;
    }
}

$classes[] = 'goyostats-modal-filter';
$classes[] = $activeFilters ? 'wp-modal-filter--active' : '';
$classes[] = is_rtl() ? 'goyostats-pull-left' : 'goyostats-pull-right';
?>

<?php

$args = [
    'filter_type'   => 'goyostats-modal',
    'classes'       => implode(' ', $classes),
    'activeFilters' => $activeFilters,
];

View::load("components/objects/header-filter-button", $args);
?>