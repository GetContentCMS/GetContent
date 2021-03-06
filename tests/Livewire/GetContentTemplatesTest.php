<?php

namespace GetContent\CMS\Tests\Livewire;

use GetContent\CMS\Facades\GetContent;
use GetContent\CMS\Models\Template;
use GetContent\CMS\Tests\TestCase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetContentTemplatesTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithViews;

    /** @test */
    public function returns_field_templates_from_db(): void
    {
        $templates = collect([
            Template::create([
                'name' => 'Video', 'slug' => 'video',
                'type' => 'field',
                'schema' => [['type' => 'text', 'modelKey' => 'videoUrl']],
            ]),
            Template::create([
                'name' => 'Download', 'slug' => 'download',
                'type' => 'field',
                'schema' => [['type' => 'file', 'modelKey' => 'file'], ['type' => 'text', 'modelKey' => 'caption']],
            ]),
        ]);

        $db_templates = GetContent::getFieldTemplates();
        $this->assertEquals($templates->pluck('name'), $db_templates->pluck('name'));
    }

    /** @test */
    public function component_lists_available_field_templates(): void
    {
        collect([
            Template::create([
                'name' => 'Video', 'slug' => 'video',
                'type' => 'field',
                'schema' => [['type' => 'text', 'modelKey' => 'videoUrl']],
            ]),
            Template::create([
                'name' => 'Download', 'slug' => 'download',
                'type' => 'field',
                'schema' => [['type' => 'file', 'modelKey' => 'file'], ['type' => 'text', 'modelKey' => 'caption']],
            ]),
        ]);

        $templatesComponent = $this->blade('<x-gc::field-templates/>');
        $templatesComponent->assertSee('Video');
        $templatesComponent->assertSee('Download');
    }
}
