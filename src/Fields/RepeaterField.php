<?php

namespace GetContent\CMS\Fields;

use Arr;
use GetContent\CMS\Document\Field;
use GetContent\CMS\Models\Template;

/**
 * @property \Illuminate\Support\Collection|string $template
 */
class RepeaterField extends Field
{
    public function getEditorViewProperty(): \Illuminate\View\View
    {
        return view('gc::editor.fields.repeater');
    }

    public function getEditorSettingsViewProperty(): \Illuminate\View\View
    {
        return view('gc::editor.fields.repeater-settings');
    }

    public static function getIcon(): string
    {
        return 'ri-function-line';
    }

    public function getTemplateProperty(): Template
    {
        $template = $this->getAttribute('template');

        if (is_string($template)) {
            return Template::whereSlug($template)->first()->setDocument($this->getDocument());
        }

        return (new Template())->fill([
            'schema' => $template,
        ])->setDocument($this->getDocument());
    }

    public function addField(): void
    {
        $items = tap(Arr::get($this->model, 'items', []), function (&$items) {
            $items[] = $this->template->fields->keys()->flip()->map(fn () => '')->toArray();
        });

        $this->model = array_merge($this->model, ['items' => $items]);
    }

    public function removeField($index): void
    {
        $items = tap(Arr::get($this->model, 'items', []), function (&$items) use ($index) {
            Arr::forget($items, $index);
        });

        $this->model = array_merge($this->model, ['items' => collect($items)->values()]);
    }
}
