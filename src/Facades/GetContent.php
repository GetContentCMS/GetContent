<?php

namespace GetContent\CMS\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class GetContent
 *
 * @method static string version()
 * @method static void registerField($alias, $class)
 * @method static array getAvailableFields()
 * @method static string getFieldClassForType()
 * @method static \Illuminate\Support\Collection getFieldTemplates()
 * @method static \Illuminate\Support\Collection getFiles()
 *
 * @see \GetContent\CMS\GetContent
 */
class GetContent extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'GetContent';
    }
}
