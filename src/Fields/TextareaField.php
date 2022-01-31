<?php

namespace GetContent\CMS\Fields;

use GetContent\CMS\Document\Field;

class TextareaField extends Field
{
    public function getEditorViewProperty(): \Illuminate\View\View
    {
        return view('gc::editor.fields.textarea');
    }

    public static function getIcon(): string
    {
        return 'ri-file-list-line';
    }
}
