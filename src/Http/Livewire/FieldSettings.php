<?php

namespace GetContent\CMS\Http\Livewire;

use Arr;
use GetContent\CMS\Document\Field;
use Illuminate\Validation\Rule;

/**
 * @property Field $field
 */
trait FieldSettings
{
    public ?string $configureFieldModelKey = null;
    public $configureFieldSchema;

    public function configureField($modelKey)
    {
        $this->configureFieldModelKey = $modelKey;
        $this->configureFieldSchema = $this->document->schema->where('modelKey', $this->configureFieldModelKey)->first();
    }

    public function getConfigureFieldProperty()
    {
        return $this->document->fields->get($this->configureFieldModelKey);
    }

    public function applyFieldSettings()
    {
        $this->validate([
            'configureFieldSchema.modelKey' => [
                'string', 'filled', 'min:1',
                Rule::notIn($this->document->model->except($this->configureFieldModelKey)->keys()),
            ],
        ]);

        $this->document->schema->transform(function ($field) {
            if (Arr::get($field, 'modelKey') === $this->configureFieldModelKey) {
                return array_merge($field, $this->configureFieldSchema);
            }

            return $field;
        });

        if (($newModelKey = Arr::get($this->configureFieldSchema, 'modelKey')) !== $this->configureFieldModelKey) {
            $this->document->changeModelKey($this->configureFieldModelKey, $newModelKey);
            $this->dehydrateModel();
        }
    }
}
