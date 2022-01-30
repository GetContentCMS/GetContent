<?php

namespace GetContent\CMS\Models;

use GetContent\CMS\Traits\HasFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property $schema
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $fields
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $group
 */
class Template extends Model
{
    use HasFactory;
    use HasFields;

    protected $fillable = ['name', 'slug', 'schema', 'meta'];

    /**
     * @var Document|null
     */
    private ?Document $document;

    protected static function booted(): void
    {
        static::creating(static function ($template) {
            $template->uuid = $template->uuid ?? (string) Str::uuid();
            $template->slug = $template->slug ?? Str::slug($template->name);
        });
    }

    public function setDocument($document = null): Template
    {
        $this->document = $document;

        return $this;
    }
}
