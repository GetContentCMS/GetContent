<?php

namespace GetContent\CMS\Tests\Models;

use GetContent\CMS\Document\Field;
use GetContent\CMS\Models\Document;
use GetContent\CMS\Models\Template;
use GetContent\CMS\Tests\TestCase;

class TemplateTest extends TestCase
{
    /** @test */
    public function adds_field(): void
    {
        $template = new Template();
        $template->addField(['type' => 'text', 'modelKey' => 'url']);
        $template->addField(['type' => 'text', 'modelKey' => 'title']);

        $this->assertEquals([
            ['type' => 'text', 'modelKey' => 'url'],
            ['type' => 'text', 'modelKey' => 'title'],
        ], $template->schema->toArray());
    }

    /** @test */
    public function increments_modelKey(): void
    {
        $template = new Template();
        $template->addField(['type' => 'text']);
        $template->addField(['type' => 'text']);

        $this->assertEquals([
            ['type' => 'text', 'modelKey' => 'text1'],
            ['type' => 'text', 'modelKey' => 'text2'],
        ], $template->schema->toArray());
    }

    /** @test */
    public function removes_field(): void
    {
        $template = new Template();
        $template->addField(['type' => 'text', 'modelKey' => 'url']);
        $template->addField(['type' => 'text', 'modelKey' => 'title']);

        $this->assertEquals([
            ['type' => 'text', 'modelKey' => 'url'],
            ['type' => 'text', 'modelKey' => 'title'],
        ], $template->schema->toArray());

        $template->removeField('url');

        $this->assertEquals([
            ['type' => 'text', 'modelKey' => 'title'],
        ], $template->schema->toArray());
    }

    /** @test */
    public function duplicates_field(): void
    {
        $template = new Template();
        $template->addField(['type' => 'text', 'modelKey' => 'url']);

        $template->duplicateField('url');

        $this->assertEquals([
            ['type' => 'text', 'modelKey' => 'url'],
            ['type' => 'text', 'modelKey' => 'text1'],
        ], $template->schema->toArray());
    }

    /**  @test */
    public function it_changes_the_field_modelKey(): void
    {
        $template = new Template(
            [
                'schema' => [
                    [
                        'type' => 'text',
                        'modelKey' => 'text1',
                    ],
                    [
                        'type' => 'text',
                        'modelKey' => 'text2',
                    ],
                ],
            ]
        );

        $template->changeModelKey('text1', 'updatedText');

        $this->assertEquals($template->schema->toArray(), [
            [
                'type' => 'text',
                'modelKey' => 'updatedText',
            ],
            [
                'type' => 'text',
                'modelKey' => 'text2',
            ],
        ]);
    }

    /** @test */
    public function gets_collection_of_fields(): void
    {
        $document = new Document();
        $template = new Template();
        $template->setDocument($document);

        $template->addField(['type' => 'text', 'modelKey' => 'url']);
        $template->addField(['type' => 'text', 'modelKey' => 'title']);

        $this->assertTrue(is_subclass_of($template->fields->first(), Field::class));
    }
}
