<?php

namespace GetContent\CMS\Models;

use GetContent\CMS\Document\Field;
use GetContent\CMS\Facades\GetContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

/**
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $model
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $schema
 * @property Group $group
 * @property \Illuminate\Support\Collection $fields
 * @property string $name
 */
class Document extends Model
{
    use HasFactory;
    use SchemalessAttributesTrait;
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'group_id', 'schema', 'model', 'meta', 'created_at'];

    protected $casts = [
        'meta' => 'collection',
    ];

    protected $dates = [
        'published_at',
    ];

    protected $schemalessAttributes = [
        'schema',
        'model',
    ];

    protected static function booted(): void
    {
        static::creating(function ($document) {
            $document->uuid = $document->uuid ?? (string) Str::uuid();
            $document->slug = $document->slug ?? Str::slug($document->name);
        });
    }

    public function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function getUsingGroupSchemaAttribute(): bool
    {
        return blank($this->schema) && $this->group && ! blank($this->group->schema);
    }

    /**
     * Transforms JSON schema into Form models
     *
     * @return \Illuminate\Support\Collection|\Spatie\SchemalessAttributes\SchemalessAttributes
     */
    public function getFieldsAttribute(): \Spatie\SchemalessAttributes\SchemalessAttributes|Collection
    {
        if ($this->usingGroupSchema) {
            return $this->group->getFieldsForDocument($this);
        }

        return $this->schema->sortBy('order')->map(
            function ($field) {
                return new (GetContent::getFieldClassForType($field['type']))($field, $this);
            }
        )->keyBy('modelKey');
    }

    /**
     * Model accessor retrieves the Field and passes the nested key
     * to the Field->model accessor
     *
     * @param  string  $key
     * @param  string|null  $nested
     * @return mixed
     */
    public function model(string $key, string $nested = null): mixed
    {
        if (Str::contains($key, '.')) {
            $nested = Str::after($key, '.');
            $key = Str::before($key, '.');
        }

        return $this->field($key)?->model($nested);
    }

    /**
     * Model accessor retrieves the Field by modelKey
     *
     * @param  string  $key
     * @return Field
     */
    public function field(string $key): ?Field
    {
        return $this->fields->get(Str::before($key, '.'));
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
     * @param  null  $initialValue
     * @param  int|null  $spliceIndex
     *
     * @return Document
     * @throws \Exception
     */
    public function addField($fieldAttributes, $initialValue = null, int $spliceIndex = null): Document
    {
        if (! Arr::has($fieldAttributes, 'modelKey')) {
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
                        if (Arr::exists($this->model, $value)) {
                            $fail("$value is not a unique model key");
                        }
                    },
                ],
                'template' => 'nullable',
            ]
        );

        if ($validator->fails()) {
            throw new \Exception('Unable to add field');
        }

        if ($spliceIndex) {
            $this->schema->splice($spliceIndex, 0, [$validator->validated()]);
        } else {
            $this->schema->push($validator->validated());
        }

        $this->model->put(
            $validator->validated()['modelKey'],
            $initialValue
        );

        return $this;
    }

    /**
     * Removes the field from the schema and model
     *
     * @param $modelKey
     * @return Document
     */
    public function removeField($modelKey): Document
    {
        $this->model->pull($modelKey);
        $this->schema = $this->schema->whereNotIn('modelKey', $modelKey);

        return $this;
    }

    /**
     * Duplicates the given field after the original
     *
     * @param $modelKey
     * @return Document
     * @throws \Exception
     */
    public function duplicateField($modelKey): Document
    {
        $field = $this->schema->firstWhere('modelKey', $modelKey);
        $index = $this->schema->search($field);
        $value = $this->model->get($field['modelKey']);
        unset($field['modelKey']);

        $this->addField($field, $value, $index + 1);

        return $this;
    }

    /**
     * Changes the modelKey of a field
     * @param  mixed  $modelKey
     * @param  mixed  $newModelKey
     * @return void
     */
    public function changeModelKey(mixed $modelKey, mixed $newModelKey): void
    {
        $this->schema->transform(function ($field) use ($newModelKey, $modelKey) {
            if ($field['modelKey'] === $modelKey) {
                $field['modelKey'] = $newModelKey;
            }

            return $field;
        });

        $this->model[$newModelKey] = $this->model[$modelKey];
        $this->model->forget($modelKey);
    }

    /**
     * Only return documents with published_at
     * dates in the future or not set
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('published_at', '<', now())
            ->orWhereNull('published_at');
    }
}
