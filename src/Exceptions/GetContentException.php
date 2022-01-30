<?php

namespace GetContent\CMS\Exceptions;

class GetContentException extends \Exception
{
    /**
     * @param  string  $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
