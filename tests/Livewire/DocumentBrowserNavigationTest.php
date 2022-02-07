<?php

namespace GetContent\CMS\Tests\Livewire;

use GetContent\CMS\Http\Livewire\DocumentBrowser;
use GetContent\CMS\Models\Document;
use GetContent\CMS\Models\Group;
use GetContent\CMS\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class DocumentBrowserNavigationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function changing_current_group_shows_nested_groups_and_docs(): void
    {
        $groups = Group::factory(2)->create();
        $nestedGroups = Group::factory(2)->create(['parent_id' => 1]);
        $documents = Document::factory(2)->create();
        $nestedDocuments = Document::factory(2)->create(['group_id' => 1]);

        Livewire::test(DocumentBrowser::class)
            ->assertSee($groups->pluck('name')->toArray())
            ->assertDontSee($nestedGroups->pluck('name')->toArray())
            ->assertSee($documents->pluck('name')->toArray())
            ->assertDontSee($nestedDocuments->pluck('name')->toArray())
            ->set('group', $groups->first())
            // Group name will appear in breadcrumb nav, so skip it here
            ->assertDontSee($groups->skip(1)->pluck('name')->toArray())
            ->assertSee($nestedGroups->pluck('name')->toArray())
            ->assertDontSee($documents->pluck('name')->toArray())
            ->assertSee($nestedDocuments->pluck('name')->toArray());
    }

    /** @test */
    public function creates_group_in_current_group(): void
    {
        $groups = Group::factory(2)->create();

        Livewire::test(DocumentBrowser::class, ['group' => $groups->first()])
            ->call('createGroup', 'This Nested Group')
            ->assertSee('Browse This Nested Group');

        $this->assertDatabaseHas('groups', ['name' => 'This Nested Group', 'parent_id' => 1]);
    }

    /** @test */
    public function creates_document_in_current_group(): void
    {
        $groups = Group::factory(2)->create();

        Livewire::test(DocumentBrowser::class, ['group' => $groups->first()])
            ->call('createDocument', 'This Nested Document')
            ->assertSee('Edit This Nested Document');

        $this->assertDatabaseHas('documents', ['name' => 'This Nested Document', 'group_id' => 1]);
    }

    /** @test */
    public function redirects_to_requested_document(): void
    {
        $document = Document::factory()->create();

        Livewire::test(DocumentBrowser::class)
            ->call('openDocument', $document->uuid)
            ->assertRedirect(route('document:editor', ['document' => $document]));
    }
}
