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
            'url' => Storage::disk('files')->url($this->filename),
            'path' => Storage::disk('files')->path($this->filename),
            'size' => Storage::disk('files')->size($this->filename),
            'mimeType' => Storage::disk('files')->getMimetype($this->filename),
            'updated_at' => Storage::disk('files')->lastModified($this->filename),
        ];
    }

    public function __get(string $name)
    {
        return Arr::get($this->info, $name);
    }
}
