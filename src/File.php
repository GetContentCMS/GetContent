<?php

namespace GetContent\CMS;

use Arr;
use Storage;

class File
{
    private string $filename;
    private array $info;

    /**
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->info = $this->info();
    }

    /**
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function info(): array
    {
        return [
            'filename' => $this->filename,
            'url' => Storage::disk(config('getcontent.file_upload_disk'))->url($this->filename),
            'path' => Storage::disk(config('getcontent.file_upload_disk'))->path($this->filename),
            'size' => Storage::disk(config('getcontent.file_upload_disk'))->size($this->filename),
            'mimeType' => Storage::disk(config('getcontent.file_upload_disk'))->getMimetype($this->filename),
            'updated_at' => Storage::disk(config('getcontent.file_upload_disk'))->lastModified($this->filename),
        ];
    }

    public function __get(string $name)
    {
        return Arr::get($this->info, $name);
    }
}
