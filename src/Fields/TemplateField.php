<?php

namespace GetContent\CMS\Fields;

use GetContent\CMS\Document\Field;
use GetContent\CMS\Models\Template;

class TemplateField extends Field
{
    public function getEditorViewProperty(): \Illuminate\View\View
    {
        return view('gc::editor.fields.template');
    }

    // @todo DRY this duplicate of RepeaterField::getTemplateProperty
    public function getTemplateProperty(): Template
    {
        $template = $this->getAttribute('template');

        if (is_string($template)) {
            return Template::whereSlug($template)->firstOrFail()->setDocument($this->getDocument());
        }

        return (new Template())->fill([
            'schema' => $template,
        ])->setDocument($this->getDocument());
    }
}
