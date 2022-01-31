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

        if (! Storage::disk(config('getcontent.file_upload_disk'))->exists($filename)) {
            return null;
        }

        return [
            'name' => Storage::disk(config('getcontent.file_upload_disk'))->getMetadata($filename)['path'],
            'url' => Storage::disk(config('getcontent.file_upload_disk'))->url($filename),
            'path' => Storage::disk(config('getcontent.file_upload_disk'))->path($filename),
            'size' => Storage::disk(config('getcontent.file_upload_disk'))->size($filename),
            'mime' => Storage::disk(config('getcontent.file_upload_disk'))->getMimetype($filename),
            'updated_at' => Storage::disk(config('getcontent.file_upload_disk'))->lastModified($filename),
        ];
    }

    public function removeFile($file): void
    {
        $this->model = collect($this->model)->filter(fn ($item) => $item !== $file);
    }
}
