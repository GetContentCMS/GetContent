<?php

namespace GetContent\CMS\Exceptions;

class FieldMethodNotFound extends \Exception
{
    /**
     * @param  string  $modelKey
     * @param  string  $method
     */
    public function __construct(string $modelKey, string $method)
    {
        parent::__construct("Method ['$method'] not found on Field class for '$modelKey'");
    }
}
