<?php

namespace GetContent\CMS\Fields;

use GetContent\CMS\Document\Field;
use Storage;

class FileField extends Field
{
    public function getEditorViewProperty(): \Illuminate\View\View
    {
        return view('gc::editor.fields.file');
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-upload';
    }

    public function asFile(): ?array
    {
        $filename = data_get($this->model, 'value');

        if (! Storage::disk('files')->exists($filename)) {
            return null;
        }

        return [
            'name' => Storage::disk('files')->getMetadata($filename)['path'],
            'url' => Storage::disk('files')->url($filename),
            'path' => Storage::disk('files')->path($filename),
            'size' => Storage::disk('files')->size($filename),
            'mime' => Storage::disk('files')->getMimetype($filename),
            'updated_at' => Storage::disk('files')->lastModified($filename),
        ];
    }

    public function removeFile($file): void
    {
        $this->model = collect($this->model)->filter(fn ($item) => $item !== $file);
    }
}
