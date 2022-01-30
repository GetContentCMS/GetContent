<?php

namespace GetContent\CMS\Fields;

use GetContent\CMS\Document\Field;

class TextField extends Field
{
    public function getEditorViewProperty(): \Illuminate\View\View
    {
        return view('gc::editor.fields.text');
    }

    public static function getIcon(): string
    {
        return 'ri-text';
    }
}
