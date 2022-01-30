<?php

namespace GetContent\CMS\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class GetContent
 * @method \Illuminate\Support\Collection items()
 * @method \GetContent\CMS\Editor\Navigation\NavItem create()
 *
 * @see \GetContent\CMS\Editor\Navigation\Nav
 */
class Nav extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Nav';
    }
}
