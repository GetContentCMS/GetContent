<?php

namespace GetContent\CMS\Fields;

use GetContent\CMS\Models\Document;

class ImageField extends FileField
{
    public function __construct($field, Document $document, string $baseModel = '')
    {
        $field = array_merge(['accept' => 'image/*'], $field);
        parent::__construct($field, $document, $baseModel);
    }

    public static function getIcon(): string
    {
        return 'ri-image-line';
    }
}
