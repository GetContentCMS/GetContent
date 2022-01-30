<?php

namespace GetContent\CMS\Fields;

use GetContent\CMS\Document\Field;
use Arr;

class ContentField extends Field
{

    public function getEditorViewProperty(): \Illuminate\View\View
    {
        return view('gc::editor.fields.content');
    }

    public static function getIcon(): string
    {
        return 'ri-draft-line';
    }

    public function getModelProperty()
    {
        return tap(parent::getModelProperty(), static function (&$model) {
            $model = Arr::wrap($model);
            if (!Arr::has($model, 'html')) {
                $model['html'] = '';
            }
        });
    }
}
