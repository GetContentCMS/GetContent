<?php

namespace GetContent\CMS\Http\Livewire;

use Arr;
use GetContent\CMS\Exceptions\FieldMethodNotFound;
use GetContent\CMS\Models\Document;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;
use Str;

class DocumentEditor extends Component
{
    use WithFileUploads;
    use FieldSettings;

    public Document $document;
    public array $schema;
    public array $model;
    public $newFile;

    protected array $rules = [
        'document.name' => 'required',
        'document.slug' => 'required',
        'document.published_at' => 'required|date',
    ];

    public function mount(): void
    {
        $this->dehydrateSchema();
        $this->dehydrateModel();
    }

    public function render()
    {
        return view('gc::livewire.document-editor')
            ->extends('gc::layouts.page')
            ->section('body');
    }

    public function hydrateSchema($schema): void
    {
        $this->document->schema = $schema;
    }

    public function dehydrateSchema(): void
    {
        $this->schema = $this->document->schema->keyBy('modelKey')->toArray();
    }

    public function hydrateModel($model): void
    {
        $this->document->model = $model;
    }

    private function dehydrateModel(): void
    {
        $this->model = collect($this->document->fields->toArray())
            ->pluck('model', 'modelKey')->toArray();
    }

    public function updatedModel($value, $key): void
    {
        $field = $this->document->fields->firstWhere('modelKey', Str::before($key, '.'));

        // Set value for dot notation nested models
        if (Str::contains($key, '.')) {
            $value = tap(Arr::wrap($field->model), function (&$newValue) use ($value, $key) {
                Arr::set($newValue, Str::of($key)->after('.'), $value);
            });
        }

        $field->model = $value;
        $this->dehydrateModel();
    }

    public function addField($type, $props = []): void
    {
        $this->document->addField(['type' => $type, ...$props]);
        $this->dehydrateModel();
    }

    public function removeField($modelKey): void
    {
        $this->document->removeField($modelKey);
        $this->dehydrateModel();

        //    Todo: Undo remove field
        $this->emit('notify', "$modelKey field removed");
    }

    public function clearField($modelKey): void
    {
        $this->document->model->set(Str::of($modelKey)->after('model.'), null);
        $this->dehydrateModel();
    }

    public function updateFieldOrder($order): void
    {
        $order = collect($order);

        $this->document->schema->transform(function ($field) use ($order) {
            $field['order'] = $order->where('value', $field['modelKey'])->first()['order'];

            return $field;
        });
    }

    public function saveNewFile($model, $filename): void
    {
        if (Storage::disk(config('getcontent.file_upload_disk'))->exists($filename)) {
            $path = pathinfo($filename);
            $filename = "{$path['filename']}-".Str::slug(now()).".{$path['extension']}";
        }

        $this->newFile->storeAs('/', $filename, 'files');
        $this->updatedModel($filename, Str::after($model, 'model.'));
        $this->newFile = null;
    }

    /**
     * @throws FieldMethodNotFound
     */
    public function callFieldMethod($modelKey, $method, ...$params)
    {
        $modelKey = Str::after($modelKey, 'model.');
        $field = $this->document->fields->firstWhere('modelKey', $modelKey);

        if (! $field || ! method_exists($field, $method)) {
            throw new FieldMethodNotFound($modelKey, $method);
        }

        return tap($field->$method(...$params), function () {
            $this->dehydrateModel();
        });
    }

    public function save(): void
    {
        $this->document->save();

        $this->emit('notify', 'Document Saved');
    }
}
