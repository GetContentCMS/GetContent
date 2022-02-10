<?php

namespace GetContent\CMS\Fields;

use GetContent\CMS\Document\Field;
use GetContent\CMS\File;
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

    /**
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function asFile(): File|null
    {
        $filename = data_get($this->model, 'value');

        if (! Storage::disk(config('getcontent.file_upload_disk'))->exists($filename)) {
            return null;
        }

        return new File($filename);
    }

    public function removeFile($file): void
    {
        $this->model = collect($this->model)->filter(fn ($item) => $item !== $file);
    }
}
