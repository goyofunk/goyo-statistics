<?php
/**
 * Plugin Name: Goyo Statistics
 * Description: 고요 간단 통계
 * Version: 1.01
 * Author: 고용펑크
 * Update URI: false
 * Text Domain: goyo-statistics
 * Domain Path: /languages
 * Requires at least: 6.6
 * Requires PHP: 7.4
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

# Exit if accessed directly
if (!defined('ABSPATH')) exit;

require_once __DIR__ . '/includes/goyo-statistics-policy.php';

# Load Plugin Defines
require_once __DIR__ . '/includes/defines.php';

# Set another useful plugin define.
define('GOYO_STATISTICS_VERSION', '14.16.18');

# Load Plugin
if (!class_exists('Goyo_Statistics')) {
    require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics.php';
}

# Returns the main instance of WP Statistics.
function Goyo_Statistics()
{
    return Goyo_Statistics::instance();
}

# Global for backwards compatibility.
$GLOBALS['Goyo_Statistics'] = Goyo_Statistics();
