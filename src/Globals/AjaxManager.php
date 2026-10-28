<?php
namespace Goyo_Statistics\Globals;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Goyo_Statistics\Components\Ajax;

class AjaxManager
{
    public function __construct()
    {
        add_action('init', [$this, 'register']);
    }

    /**
     * Register AJAX callbacks.
     *
     * @example Ajax::register('test', [$this, 'test'])
     */
    public function register()
    {

    }
}