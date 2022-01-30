<?php

namespace GetContent\CMS\Traits;

use GetContent\CMS\Facades\GetContent;
use GetContent\CMS\Models\Document;
use GetContent\CMS\Models\Template;
use Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Validator;

trait HasFields
{
    use SchemalessAttributesTrait;

    protected $schemalessAttributes = [
        'schema',
    ];

    protected string $baseModel = '';

    /**
     * Transforms JSON schema into Form models
     *
     * @return \Illuminate\Support\Collection|\Spatie\SchemalessAttributes\SchemalessAttributes
     */
    public function getFieldsAttribute(): \Spatie\SchemalessAttributes\SchemalessAttributes|Collection
    {
        if (empty($this->schema) && self::class === Document::class) {
            return $this->group->fields;
        }

        return $this->schema->sortBy('order')->map(
            function ($field, $index) {
                $document = (self::class === Document::class) ? $this : $this->document;
                return new (GetContent::getFieldClassForType($field['type']))($field, $document, $this->baseModel);
            }
        )->keyBy('modelKey');
    }

    /**
     * Calculates the next auto model name for the specified field type
     * by pulling out model names with the same type and
     * incrementing the highest iteration
     *
     * @param $type
     * @param  Collection|null  $schema
     * @return string
     */
    public function nextModelOfType($type, Collection $schema = null): string
    {
        $lastOfType = ($schema ?? $this->schema)
            ->where('type', $type)
            ->pluck('modelKey')
            ->filter(
                function ($item) use ($type) {
                    return Str::startsWith($item, $type);
                }
            )
            ->sort()
            ->last();

        return $type.((int) filter_var($lastOfType, FILTER_SANITIZE_NUMBER_INT) + 1);
    }

    /**
     * Add a new Field to the document
     *
     * @param $fieldAttributes
     * @param  int|null  $spliceIndex
     *
     * @return HasFields
     * @throws \Exception
     */
    public function addField($fieldAttributes, int $spliceIndex = null): static
    {
        if (!Arr::has($fieldAttributes, 'modelKey')) {
            // Auto create model key
            $fieldAttributes['modelKey'] = $this->nextModelOfType(Arr::get($fieldAttributes, 'type'));
        }

        $validator = Validator::make(
            $fieldAttributes,
            [
                'type' => 'required',
                'modelKey' => [
                    function ($attribute, $value, $fail) {
                        // needs to be a unique model key
                        if ($this->schema->pluck('modelKey')->contains($value)) {
                            $fail("$value is not a unique model key");
                        }
                    },
                ],
            ]
        );

        if ($validator->fails()) {
            throw new \RuntimeException('Unable to add field');
        }

        if ($spliceIndex) {
            $this->schema->splice($spliceIndex, 0, [$validator->validated()]);
        } else {
            $this->schema->push($validator->validated());
        }

        return $this;
    }

    /**
     * Removes the field from the schema
     *
     * @param $modelKey
     * @return HasFields
     */
    public function removeField($modelKey): static
    {
        $this->schema = $this->schema->whereNotIn('modelKey', $modelKey)->values();

        return $this;
    }

    /**
     * Duplicates the given field after the original
     *
     * @param $modelKey
     * @return Template|HasFields
     * @throws \Exception
     */
    public function duplicateField($modelKey): self
    {
        $field = $this->schema->firstWhere('modelKey', $modelKey);
        $index = $this->schema->search($field);
        unset($field['modelKey']);

        $this->addField($field, $index + 1);

        return $this;
    }

    public function changeModelKey(mixed $modelKey, mixed $newModelKey): void
    {
        $this->schema->transform(function ($field) use ($newModelKey, $modelKey) {
            if ($field['modelKey'] === $modelKey) {
                $field['modelKey'] = $newModelKey;
            }

            return $field;
        });
    }

    /**
     * @param  string  $baseModel
     * @return Template|HasFields
     */
    public function setBaseModel(string $baseModel): self
    {
        $this->baseModel = $baseModel;

        return $this;
    }
}
