<?php

namespace GetContent\CMS\Fields;

use Carbon\Carbon;
use GetContent\CMS\Document\Field;

class DateField extends Field
{
    public function getEditorViewProperty(): \Illuminate\View\View
    {
        return view('gc::editor.fields.date');
    }

    public static function getIcon(): string
    {
        return 'ri-calendar-line';
    }

    public function asDate()
    {
        return Carbon::parse($this->model['value']);
    }
}
