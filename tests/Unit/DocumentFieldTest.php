<?php

namespace GetContent\CMS\Tests\Unit;

use Arr;
use GetContent\CMS\Document\Field;
use GetContent\CMS\Facades\GetContent;
use GetContent\CMS\Models\Document;
use GetContent\CMS\Tests\TestCase;

class DocumentFieldTest extends TestCase
{
    /** @test */
    public function it_registers_a_field(): void
    {
        GetContent::registerField('text', TextField::class);

        $this->assertEquals(
            TextField::class,
            GetContent::getFieldClassForType('text')
        );
    }

    /** @test */
    public function it_throws_exception_when_registering_unextended_field(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Fields must extend GetContent Field class');
        GetContent::registerField('bad', BadField::class);
    }

    /** @test */
    public function it_returns_an_instance_of_the_relevant_field_class(): void
    {
        GetContent::registerField('text', TextField::class);
        $this->assertEquals(TextField::class, GetContent::getFieldClassForType('text'));
    }

    /** @test */
    public function it_returns_an_instance_of_base_field_class_when_not_registered(): void
    {
        $this->assertEquals(Field::class, GetContent::getFieldClassForType('notARealFieldType'));
    }

    /** @test */
    public function label_creates_a_dynamic_label(): void
    {
        $field = new Field([
            'type' => 'text',
            'modelKey' => 'text1',
        ], new Document());

        $this->assertEquals('Text1 field', $field->label);
    }

    /** @test */
    public function label_returns_given_label_when_set(): void
    {
        $field = new Field([
            'type' => 'text',
            'modelKey' => 'text1',
            'label' => 'My Text',
        ], new Document());

        $this->assertEquals('My Text', $field->label);
    }

    /** @test */
    public function givenLabel_returns_given_label(): void
    {
        $field = new Field([
            'type' => 'text',
            'modelKey' => 'text1',
            'label' => 'My Label',
        ], new Document());

        $this->assertEquals('My Label', $field->givenLabel);
    }

    /** @test */
    public function givenLabel_returns_null_when_unset(): void
    {
        $field = new Field([
            'type' => 'text',
            'modelKey' => 'text1',
        ], new Document());

        $this->assertEquals(null, $field->givenLabel);
    }

    /** @test */
    public function it_sets_the_label(): void
    {
        $field = new Field([
            'type' => 'text',
            'modelKey' => 'text1',
        ], new Document());

        $this->assertEquals('Text1 field', $field->label);
        $field->label = 'My Field Label';
        $this->assertEquals('My Field Label', $field->label);
    }

    /** @test */
    public function it_returns_an_array_including_model(): void
    {
        /** @var Document $document */
        $document = Document::factory()->make();

        $document->addField(['type' => 'text'], 'Some value');
        $field = $document->fields->first();

        $this->assertEquals([
            'modelKey' => 'text1',
            'order' => 0,
            'type' => 'text',
            'model' => 'Some value',
        ], $field->toArray());
    }

    /** @test */
    public function it_returns_default_view_for_editor(): void
    {
        $document = Document::factory()->make();
        $document->addField(['type' => 'no-registered-field'], 'Some value');

        $this->assertEquals(
            view('gc::editor.fields.unknown'),
            $document->fields->first()->editorView
        );
    }

    /** @test */
    public function it_can_mutate_the_model_being_set(): void
    {
        $field = new ChangeModelOnSet([
            'type' => 'text',
            'modelKey' => 'text1',
        ], Document::factory()->make());

        $field->model = 'foo';
        $this->assertEquals('FOO', $field->model);
    }

    /** @test */
    public function it_mutates_the_model_being_retrieved(): void
    {
        $field = new ChangeModelOnGet([
            'type' => 'text',
            'modelKey' => 'text1',
        ], Document::factory()->make(['model' => ['text1' => 'foo']]));

        $this->assertEquals('FOO', $field->model);
    }

    /** @test */
    public function it_gets_field_schema_attribute(): void
    {
        $field = new Field([
            'type' => 'text',
            'modelKey' => 'text1',
        ], new Document());

        $this->assertEquals('text', $field->type);
    }

    /** @test */
    public function it_inits_model_suffix(): void
    {
        $doc = new Document();
        $field = new Field([
            'type' => 'text',
            'modelKey' => 'text1',
        ], $doc);

        $this->assertArrayNotHasKey('value', $field->model);
        $this->assertFalse(Arr::has($doc->model, 'text1.value'));
        $field->getModelPath('value');
        $this->assertArrayHasKey('value', $field->model);
        $this->assertTrue(Arr::has($doc->model, 'text1.value'));
    }

    /** @test */
    public function it_returns_the_model_value(): void
    {
        /** @var Document $document */
        $document = Document::factory()->make();

        $document->addField(['type' => 'text'], ['value' => 'Some value']);
        $field = $document->fields->first();
        $this->assertEquals('Some value', $field->model());
    }

    /** @test */
    public function it_returns_any_model_value_by_key(): void
    {
        /** @var Document $document */
        $document = Document::factory()->make();

        $document->addField(['type' => 'text'], ['value' => 'Some value', 'options' => ['cssClasses' => 'bg-white']]);
        $field = $document->fields->first();
        $this->assertEquals('bg-white', $field->model('options.cssClasses'));
    }

    /** @test */
    public function it_looks_for_value_suffix_on_model_keys(): void
    {
        /** @var Document $document */
        $document = Document::factory()->make();

        $document->addField(['type' => 'repeater'], ['items' => [['url' => ['value' => 'https://example.com']]]]);
        $field = $document->fields->first();
        $this->assertEquals('https://example.com', $field->model('items.0.url'));
    }
}

class TextField extends Field
{
}

class BadField
{
}

class ChangeModelOnSet extends Field
{
    public function setModelProperty($value): void
    {
        $value = strtoupper($value);
        parent::setModelProperty($value);
    }
}

class ChangeModelOnGet extends Field
{
    public function getModelProperty()
    {
        return strtoupper(parent::getModelProperty());
    }
}
