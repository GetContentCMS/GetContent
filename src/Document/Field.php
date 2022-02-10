<?php

namespace GetContent\CMS\Document;

use Exception;
use GetContent\CMS\Models\Document;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Str;

/**
 * @property array|\Illuminate\Support\Collection $model
 * @property string $type
 * @property string $modelKey
 * @property string $fullModelKey
 * @property string $label
 */
class Field implements Arrayable
{
    /**
     * @var Document
     */
    private Document $document;

    private array $attributes = [
        'modelKey' => null,
        'order' => 0,
    ];

    /**
     * @var string
     */
    private string $baseModel;

    /**
     * @param  array  $field
     * @param  Document  $document
     * @param  string  $baseModel
     */
    public function __construct(array $field, Document $document, string $baseModel = '')
    {
        $this->attributes = array_merge($this->attributes, $field);
        $this->document = $document;
        $this->setBaseModel($baseModel);
    }

    public static function getName(): \Illuminate\Support\Stringable
    {
        return Str::of(static::class)->afterLast('\\')->remove('Field')->headline();
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-cube';
    }

    /**
     * Pass request for properties to a getter method
     * or look in the $attributes property
     *
     * @param $name
     * @return array|mixed
     */
    public function __get($name)
    {
        $method = 'get'.ucfirst($name).'Property';

        if (! method_exists($this, $method)) {
            return Arr::get($this->attributes, $name);
        }

        return $this->$method();
    }

    /**
     * Pass requests to set properties
     * to a setter or return false
     *
     * @param $name
     * @param $value
     * @return Field
     * @throws Exception
     */
    public function __set($name, $value)
    {
        $method = 'set'.ucfirst($name).'Property';

        if (! method_exists($this, $method)) {
            Arr::set($this->attributes, $name, $value);

            // @todo Refactor this attempt to sync $this->attributes and $this->document->schema
            $this->document->schema->transform(function ($definition) use ($value, $name) {
                if ($definition['modelKey'] === $this->modelKey) {
                    Arr::set($definition, $name, $value);
                }

                return $definition;
            });

            return $this;
        }

        $this->$method($value);

        return $this;
    }

    public function __isset($name)
    {
        return Arr::has($this->attributes, $name);
    }

    public function getFullModelKeyProperty(): string
    {
        return $this->baseModel.Arr::get($this->attributes, 'modelKey');
    }

    public function getModelPath($suffix = null): string
    {
        if ($suffix && ! collect($this->model)->has($suffix)) {
            $this->model = collect($this->model)->put($suffix, '');
        }

        return "model.{$this->fullModelKey}".($suffix ? ".{$suffix}" : '');
    }

    public function getModelProperty()
    {
        return $this->document->model->get($this->fullModelKey, collect());
    }

    public function setModelProperty($value): void
    {
        $this->document->model->set($this->fullModelKey, $value);
    }

    /**
     * @param $key
     * @return \ArrayAccess|mixed
     */
    public function model($key = null): mixed
    {
        return Arr::get(
            $this->model,
            implode('.', [$key, 'value']),
            Arr::get($this->model, $key ?? 'value')
        );
    }

    public function getLabelProperty(): string
    {
        return Arr::get($this->attributes, 'label', ucfirst($this->modelKey).' field');
    }

    public function setLabelProperty($label): void
    {
        $this->attributes['label'] = $label;
    }

    public function getGivenLabelProperty(): ?string
    {
        return Arr::get($this->attributes, 'label');
    }

    public function setGivenLabelProperty($label): void
    {
        $this->setLabelProperty($label);
    }

    public function getEditorViewProperty(): \Illuminate\Contracts\View\View
    {
        return view('gc::editor.fields.unknown');
    }

    public function getEditorSettingsViewProperty()
    {
        return view('gc::editor.fields.blank');
    }

    public function getAttribute($key)
    {
        return Arr::get($this->attributes, $key);
    }

    public function toArray(): array
    {
        return tap(
            $this->attributes,
            fn (&$attributes) => $attributes['model'] = $this->model
        );
    }

    /**
     * @return Document
     */
    public function getDocument(): Document
    {
        return $this->document;
    }

    /**
     * @param  string  $baseModel
     * @return Field
     */
    public function setBaseModel(string $baseModel): Field
    {
        $this->baseModel = $baseModel.(blank($baseModel) ? '' : '.');

        return $this;
    }
}
