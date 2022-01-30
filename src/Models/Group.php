<?php

namespace GetContent\CMS\Models;

use GetContent\CMS\Facades\GetContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Str;

class Group extends Model
{
    use HasFactory;
    use SchemalessAttributesTrait;
    use SoftDeletes;
    use NodeTrait;

    protected $guarded = [];

    protected $schemalessAttributes = [
        'schema',
        'meta',
    ];

    protected static function booted()
    {
        static::creating(function ($group) {
            $group->uuid = $group->uuid ?? (string) Str::uuid();
            $group->slug = $group->slug ?? Str::slug($group->name);
        });
    }

    public function documents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Deletes all Documents from this and descendant Groups
     *
     * @return Group
     * @throws \Exception
     */
    public function deleteDescendantDocuments(): static
    {
        $descendantsAndSelf = self::descendantsAndSelf($this->id)->pluck('id');
        Document::whereIn('group_id', $descendantsAndSelf)->delete();

        return $this;
    }

    /**
     * @param  Document  $document
     * @return Collection
     */
    public function getFieldsForDocument(Document $document): Collection
    {
        return $this->schema->sortBy('order')->map(
            function ($field) use ($document) {
                return new (GetContent::getFieldClassForType($field['type']))($field, $document);
            }
        )->keyBy('modelKey');
    }
}
