<?php

namespace GetContent\CMS;

use Exception;
use GetContent\CMS\Document\Field;
use GetContent\CMS\Exceptions\GetContentException;
use GetContent\CMS\Models\Document;
use GetContent\CMS\Models\Group;
use GetContent\CMS\Models\Template;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Str;

class GetContent
{
    private array $fields = [];
    private array $editorStyles = [];

    public static function version()
    {
        return (new Composer())->version();
    }

    /**
     * @throws Exception
     */
    public function registerField($alias, $class): void
    {
        if (! is_subclass_of($class, Field::class)) {
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

    public function getFieldTemplates($type = 'field')
    {
        $templates = Template::query();

        if ($type) {
            $templates->whereType($type);
        }

        return $templates->get();
    }

    public function getFiles($path = '/', $mime = null): \Illuminate\Support\Collection
    {
        $mimeToMatch = Str::before($mime, '*');

        return collect(Storage::disk(config('getcontent.file_upload_disk'))->files($path))
            ->filter(function ($file) use ($mimeToMatch) {
                if ($mimeToMatch) {
                    return Str::startsWith(
                        Storage::disk(config('getcontent.file_upload_disk'))->getMimetype($file),
                        $mimeToMatch
                    );
                }

                return true;
            })->merge(Storage::disk(config('getcontent.file_upload_disk'))->directories($path))
            ->map(function ($file) {
                return new File($file);
            });
    }

    public function pushStyles(...$styles): void
    {
        $this->editorStyles = array_merge($this->editorStyles, $styles);
    }

    public function getStyles(): array
    {
        return $this->editorStyles;
    }

    public static function asset($url = '/'): string
    {
        return asset(URL::asset('vendor/getcontent/cms/'.$url));
    }

    public function documents()
    {
        return Document::query();
    }

    public function documentsFromGroup($groupSlug)
    {
        return Group::whereSlug($groupSlug)->firstOrFail()->documents();
    }
}
