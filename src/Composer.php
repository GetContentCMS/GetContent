<?php

namespace GetContent\CMS;

class Composer
{
    private object $data;
    private $composerFilePath = __DIR__ . '/../composer.json';

    public function __construct($filePath = null)
    {
        if ($filePath) {
            $this->composerFilePath = $filePath;
        }

        $this->loadComposerFile();
    }

    public function loadComposerFile(): void
    {
        if (! file_exists($this->composerFilePath)) {
            return;
        }

        $this->data = json_decode(file_get_contents($this->composerFilePath), false, 512, JSON_THROW_ON_ERROR);
    }

    public function get($key, $default = null)
    {
        return data_get($this->data, $key, $default);
    }

    public function version()
    {
        return $this->get('version', 'alpha');
    }
}
