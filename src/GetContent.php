<?php

namespace GetContent\CMS;

use GetContent\CMS\Document\Field;
use GetContent\CMS\Exceptions\GetContentException;
use GetContent\CMS\Models\Template;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Str;

class GetContent
{
    private array $fields = [];

    public static function version()
    {
        return (new Composer())->version();
    }

    /**
     * @throws Exception
     */
    public function registerField($alias, $class): void
    {
        if (!is_subclass_of($class, Field::class)) {
            throw new GetContentException('Fields must extend GetContent Field class');
        }

        $this->fields[$alias] = $class;
    }

    public function getAvailableFields(): \Illuminate\Support\Collection
    {
        return collect($this->fields);
    }

    public function getFieldClassForType($type): string
    {
        return $this->getAvailableFields()->get($type) ?? Field::class;
    }

    public function getFieldTemplates()
    {
        return Template::all();
    }

    public function getFiles($mime = null): \Illuminate\Support\Collection
    {
        $mimeToMatch = Str::before($mime, '*');

        return collect(Storage::drive('files')->allFiles())->filter(function ($file) use ($mimeToMatch) {
            if ($mimeToMatch) {
                return Str::startsWith(Storage::drive('files')->getMimetype($file), $mimeToMatch);
            }

            return true;
        })->map(function ($file) {
            return new File($file);
        });
    }

    public static function asset($url = '/'): string
    {
        return asset(URL::asset('vendor/getcontent/cms/' . $url));
    }
}
