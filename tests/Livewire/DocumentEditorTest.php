<?php

namespace GetContent\CMS\Tests\Livewire;

use GetContent\CMS\Document\Field;
use GetContent\CMS\Exceptions\FieldMethodNotFound;
use GetContent\CMS\Facades\GetContent;
use GetContent\CMS\Fields\FileField;
use GetContent\CMS\Http\Livewire\DocumentEditor;
use GetContent\CMS\Models\Document;
use GetContent\CMS\Models\Template;
use GetContent\CMS\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

class DocumentEditorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_removes_fields(): void
    {
        $document = Document::factory()->make();
        $document->addField(['type' => 'text'], 'My Text Field');
        $document->addField(['type' => 'date'], '2021/10/19');
        $document->addField(['type' => 'html'], '<p>Some HTML</p>');

        // Assert fields are removed — catches issues of data
        Livewire::test(DocumentEditor::class, ['document' => $document])
            ->assertSee('Text1 field')
            ->assertSee('Date1 field')
            ->assertSee('Html1 field')
            ->call('removeField', 'text1')
            ->assertDontSee('Text1 field')
            ->assertSee('Date1 field')
            ->assertSee('Html1 field')
            ->call('removeField', 'date1')
            ->assertDontSee('Text1 field')
            ->assertDontSee('Date1 field')
            ->assertSee('Html1 field')
            ->call('removeField', 'html1')
            ->assertDontSee('Text1 field')
            ->assertDontSee('Date1 field')
            ->assertDontSee('Html1 field');
    }

    /** @test */
    public function it_adds_a_field(): void
    {
        $document = Document::factory()->make();
        $document->addField(['type' => 'text'], 'My Text Field');

        // Assert fields are removed — catches issues of data
        Livewire::test(DocumentEditor::class, ['document' => $document])
            ->assertSeeHtml('wire:key="field-text1"')
            ->assertDontSeeHtml('wire:key="field-text2"')
            ->call('addField', 'text')
            ->assertSeeHtml('wire:key="field-text2"');
    }

    /** @test */
    public function it_adds_a_field_template(): void
    {
        $document = Document::factory()->make();
        Template::factory()->make(['slug' => 'template-slug'])->save();

        Livewire::test(DocumentEditor::class, ['document' => $document])
            ->assertDontSeeHtml('wire:key="field-template1"')
            ->call('addField', 'template', ['template' => 'template-slug'])
            ->assertSeeHtml('wire:key="field-template1"')
            ->call('save');

        $document = Document::first();
        $this->assertEquals($document->schema->values()->toArray(), [[
            'type' => 'template',
            'template' => 'template-slug',
            'modelKey' => 'template1',
        ]]);
    }

    /** @test */
    public function it_updates_the_model(): void
    {
        $document = Document::factory()->make();
        $document->addField(['type' => 'text'], 'My Text Field');

        Livewire::test(DocumentEditor::class, ['document' => $document])
            ->assertSee('model.text1', 'My Text Field')
            ->updateProperty('model.text1', 'New Value')
            ->assertSee('model.text1', 'New Value');
    }

    /** @test */
    public function it_updates_nested_models(): void
    {
        $document = Document::factory()->make();
        $document->addField([
            'type' => 'repeater',
            'template' => [['type' => 'text', 'modelKey' => 'text1']],
        ]);

        Livewire::test(DocumentEditor::class, ['document' => $document])
            ->assertSet('model.repeater1.value.0.text1.value', '')
            ->updateProperty('model.repeater1.value.0.text1.value', 'New Value')
            ->assertSet('model.repeater1.value.0.text1.value', 'New Value');
    }

    /** @test */
    public function field_class_mutates_model(): void
    {
        GetContent::registerField('text', MutateModelField::class);

        $document = Document::factory()->make();
        $document->addField(['type' => 'text'], 'My Text Field');

        Livewire::test(DocumentEditor::class, ['document' => $document])
            ->assertSet('model.text1', 'My Text Field')
            ->updateProperty('model.text1', 'Updated text')
            ->assertPayloadSet('model.text1', 'UPDATED TEXT');
    }

    /** @test */
    public function calls_method_on_field_class(): void
    {
        GetContent::registerField('repeater', FieldWithActions::class);

        $document = Document::factory()->make();
        $document->addField(['type' => 'repeater'], []);

        Livewire::test(DocumentEditor::class, ['document' => $document])
            ->assertSet('model.repeater1', [])
            ->call('callFieldMethod', 'repeater1', 'addItemToModel', ['key1' => 'value'])
            ->call('callFieldMethod', 'repeater1', 'addItemToModel', ['key2' => 'another value'])
            ->assertSet('model.repeater1', [['key1' => 'value'], ['key2' => 'another value']]);
    }

    /** @test */
    public function throws_exception_when_field_method_not_found(): void
    {
        $this->expectException(FieldMethodNotFound::class);

        $document = Document::factory()->make();
        $document->addField(['type' => 'noFieldClass'], 'foo');

        Livewire::test(DocumentEditor::class, ['document' => $document])
            ->call('callFieldMethod', 'noFieldClass1', 'notAMethod', ['key1' => 'value']);
    }

    /** @test */
    public function uploads_files_saving_them_to_the_model(): void
    {
        $document = Document::factory()->make();
        $document->addField(['type' => 'file']);

        $file = UploadedFile::fake()->create('PdUgQW5AurLryNjMfYZvJsN6ytty5yMDYrqMzqPt.pdf');
        Storage::fake('files');

        Livewire::test(DocumentEditor::class, ['document' => $document])
            ->set('newFile', $file)
            ->call('saveNewFile', 'file1.value', 'my-file.pdf')
            ->assertSet('model.file1.value', 'my-file.pdf')
            ->assertSet('newFile', null);
    }

    /** @test */
    public function file_can_be_removed_from_field(): void
    {
        Storage::fake('files');
        GetContent::registerField('file', FileField::class);

        $this->withoutExceptionHandling();

        $document = Document::factory()->make();
        $document->addField(['type' => 'file'], ['value' => 'my-file.pdf']);

        Livewire::test(DocumentEditor::class, ['document' => $document])
            ->assertSet('model.file1.value', 'my-file.pdf')
            ->call('callFieldMethod', 'file1', 'removeFile', 'my-file.pdf')
            ->assertNotSet('model.file1.value', 'my-file.pdf');
    }
}

class MutateModelField extends Field
{
    public function setModelProperty($value): void
    {
        $value = strtoupper($value);
        parent::setModelProperty($value);
    }
}

class FieldWithActions extends Field
{
    public function addItemToModel($item): void
    {
        $this->model = collect($this->model)->push($item);
    }
}
