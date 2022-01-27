<?php

namespace GetContent\GetContent\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \GetContent\GetContent\GetContent
 */
class GetContent extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'getcontent';
    }
}
