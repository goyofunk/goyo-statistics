<?php

namespace Goyo_Statistics\Abstracts;

use GOYO_STATISTICS\Menus;
use Goyo_Statistics\Utils\Request;


abstract class BaseView
{
    protected $dataProvider;

    abstract protected function render();

    /**
     * Get the current page based on the "page" request parameter.
     *
     * @return string The current page.
     */
    protected function getCurrentPage()
    {
        return Menus::getPageKeyFromSlug(Request::get('page'))[0] ?? '';
    }
}