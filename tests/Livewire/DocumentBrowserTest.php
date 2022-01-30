<?php

namespace GetContent\CMS\Tests\Livewire;

use GetContent\CMS\Http\Livewire\DocumentBrowser;
use GetContent\CMS\Models\Document;
use GetContent\CMS\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use GetContent\CMS\Tests\TestCase;
use Livewire\Livewire;

class DocumentBrowserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function shows_documents()
    {
        Document::factory()->create(['name' => 'Test Document']);

        Livewire::test(DocumentBrowser::class)
            ->assertSee('Test Document');
    }

    /** @test */
    public function creates_new_document()
    {
        Livewire::test(DocumentBrowser::class)
            ->assertDontSee('Test Document')
            ->call('createDocument', 'Test Document')
            ->assertSee('Test Document');

        $this->assertDatabaseHas('documents', ['name' => 'Test Document']);
    }

    /** @test */
    public function deletes_selected_documents()
    {
        $documents = Document::factory(5)->create();

        Livewire::test(DocumentBrowser::class)
            ->assertSee($documents->pluck('name')->toArray())
            ->call('deleteDocuments', $documents->take(3)->pluck('uuid'))
            ->assertDontSee($documents->take(3)->pluck('name')->toArray())
            ->assertSee($documents->skip(3)->pluck('name')->toArray());

        $documents->take(3)->each(function ($document) {
            $this->assertSoftDeleted($document);
        });

        $documents->skip(3)->each(function ($document) {
            $this->assertNotSoftDeleted($document);
        });
    }

    /** @test */
    public function create_new_group()
    {
        Livewire::test(DocumentBrowser::class)
            ->assertDontSee('New Group Name')
            ->call('createGroup', 'New Group Name')
            ->assertSee('New Group Name');

        $this->assertDatabaseHas('groups', ['name' => 'New Group Name']);
    }

    /** @test */
    public function deletes_selected_groups_and_nested_groups()
    {
        $groups = Group::factory(2)->create();
        $nestedGroups = Group::factory(2)->create(['parent_id' => 1]);

        Livewire::test(DocumentBrowser::class)
            ->assertSee($groups->first()->name)
            ->call('deleteGroups', [$groups->first()->uuid])
            ->assertDontSee($groups->first()->name);

        $this->assertSoftDeleted($groups->first());

        $this->assertNotSoftDeleted($groups->last());

        $nestedGroups->each(function ($group) {
            $this->assertSoftDeleted($group);
        });
    }

    /** @test */
    public function deletes_selected_groups_and_nested_documents()
    {
        $groups = Group::factory(2)->create();
        $nestedDocuments = Document::factory(2)->create(['group_id' => 1]);
        $otherDocuments = Document::factory(2)->create();

        Livewire::test(DocumentBrowser::class)
            ->assertSee($groups->first()->name)
            ->call('deleteGroups', [$groups->first()->uuid])
            ->assertDontSee($groups->first()->name);

        $this->assertSoftDeleted($groups->first());

        $nestedDocuments->each(function ($document) {
            $this->assertSoftDeleted($document);
        });

        $otherDocuments->each(function ($document) {
            $this->assertNotSoftDeleted($document);
        });
    }

    /** @test */
    public function deletes_selected_items_from_groups_and_documents()
    {
        $groups = Group::factory(2)->create();
        $documents = Document::factory(5)->create();

        Livewire::test(DocumentBrowser::class)
            ->call('deleteItems', [$groups->first()->uuid], $documents->take(3)->pluck('uuid'))
            ->assertDontSee($groups->first()->name)
            ->assertDontSee($documents->first()->name);

        $this->assertSoftDeleted($groups->first());
        $this->assertNotSoftDeleted($groups->last());

        $documents->take(3)->each(function($document) {
            $this->assertSoftDeleted($document);
        });

        $documents->skip(3)->each(function($document) {
            $this->assertNotSoftDeleted($document);
        });
    }
}
