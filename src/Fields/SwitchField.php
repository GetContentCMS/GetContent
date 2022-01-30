<?php

namespace GetContent\CMS\Fields;

use GetContent\CMS\Document\Field;

class SwitchField extends Field
{
    public function getEditorViewProperty(): \Illuminate\View\View
    {
        return view('gc::editor.fields.switch');
    }

    public static function getIcon(): string
    {
        return 'ri-toggle-line';
    }
}
