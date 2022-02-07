<?php

namespace GetContent\CMS\Tests\Models;

use GetContent\CMS\Models\Document;
use GetContent\CMS\Tests\TestCase;

class DocumentTest extends TestCase
{
    /** @test */
    public function generates_model_name_for_new_field(): void
    {
        $document = new Document(
            [
                'schema' => [
                    ['type' => 'text', 'modelKey' => 'text'],
                    ['type' => 'text', 'modelKey' => 'text2'],
                    ['type' => 'text', 'modelKey' => 'text6'],
                ],
            ]
        );

        $this->assertEquals('text7', $document->nextModelOfType('text'));
    }

    /** @test */
    public function adds_field(): void
    {
        $document = new Document(
            [
                'schema' => [
                    [
                        'type' => 'text',
                        'modelKey' => 'text1',
                    ],
                ],
                'model' => [
                    'text1' => 'This is some text',
                ],
            ]
        );

        $document->addField(['type' => 'text']);

        $this->assertEquals('text2', $document->schema[1]['modelKey']);
        $this->assertArrayHasKey('text2', $document->model->toArray());
    }

    /** @test */
    public function removes_field(): void
    {
        $document = new Document(
            [
                'schema' => [
                    [
                        'type' => 'text',
                        'modelKey' => 'text1',
                    ],
                    [
                        'type' => 'content',
                        'modelKey' => 'content1',
                    ],
                ],
                'model' => [
                    'text1' => 'This is some text',
                    'content1' => '<strong>A bit of content</strong>',
                ],
            ]
        );

        $document->removeField('text1');

        $this->assertArrayNotHasKey('text1', $document->model->toArray());
        $this->assertArrayHasKey('content1', $document->model->toArray());
        $this->assertNotSame(
            [
                'type' => 'text',
                'modelKey' => 'text1',
            ],
            $document->schema->first()
        );
        $this->assertSame(
            [
                'type' => 'content',
                'modelKey' => 'content1',
            ],
            $document->schema->first()
        );
    }

    /** @test */
    public function add_field_with_initial_value(): void
    {
        $document = new Document(
            [
                'schema' => [
                    [
                        'type' => 'text',
                        'modelKey' => 'text1',
                    ],
                ],
                'model' => [
                    'text1' => 'This is some text',
                ],
            ]
        );

        $document->addField(['type' => 'text'], ['value' => 'Some kind of message']);

        $this->assertArrayHasKey('text2', $document->model);
        $this->assertSame(['value' => 'Some kind of message'], $document->model->text2);
    }

    /** @test */
    public function splice_field_into_schema(): void
    {
        $document = new Document(
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
                    [
                        'type' => 'text',
                        'modelKey' => 'text3',
                    ],
                ],
                'model' => [
                    'text1' => 'This is some text',
                    'text2' => 'This is some other text',
                    'text3' => 'This is some more text',
                ],
            ]
        );

        $document->addField(['type' => 'text'], 'This was spliced in', 1);

        $this->assertSame('This was spliced in', $document->model['text4']);
        $this->assertEquals(
            ['text1', 'text4', 'text2', 'text3'],
            $document->schema->pluck('modelKey')->toArray()
        );
    }

    /** @test */
    public function duplicates_field(): void
    {
        $document = new Document(
            [
                'schema' => [
                    [
                        'type' => 'text',
                        'modelKey' => 'text1',
                    ],
                    [
                        'type' => 'content',
                        'modelKey' => 'content1',
                    ],
                    [
                        'type' => 'media',
                        'modelKey' => 'media1',
                    ],
                ],
                'model' => [
                    'text1' => ['value' => 'This is some text'],
                    'content1' => ['value' => '<strong>A bit of formatted content</strong>'],
                    'media1' => ['url' => '/path/to/file.png'],
                ],
            ]
        );

        $document->duplicateField('content1');

        $this->assertArrayHasKey('content2', $document->model);
        $this->assertEquals('content2', $document->schema[2]['modelKey']);
    }

    /** @test */
    public function it_changes_the_field_modelKey(): void
    {
        $document = new Document(
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
                'model' => [
                    'text1' => ['value' => 'This is some text'],
                    'text2' => ['value' => 'This is some more text'],
                ],
            ]
        );

        $document->changeModelKey('text1', 'updatedText');

        $this->assertEquals([
            [
                'type' => 'text',
                'modelKey' => 'updatedText',
            ],
            [
                'type' => 'text',
                'modelKey' => 'text2',
            ],
        ], $document->schema->toArray());

        $this->assertEquals([
            'updatedText' => ['value' => 'This is some text'],
            'text2' => ['value' => 'This is some more text'],
        ], $document->model->toArray());
    }

    /** @test */
    public function it_get_model_from_field(): void
    {
        $document = new Document(
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
                'model' => [
                    'text1' => ['value' => 'This is some text'],
                    'text2' => ['value' => 'This is some more text'],
                ],
            ]
        );

        $this->assertEquals('This is some text', $document->model('text1'));
    }

    /** @test */
    public function it_gets_nested_values_from_field(): void
    {
        $document = new Document(
            [
                'schema' => [
                    [
                        'type' => 'repeater',
                        'modelKey' => 'repeater1',
                    ],
                ],
                'model' => [
                    'repeater1' => ['items' => [['text1' => ['value' => 'This is the value']]]],
                ],
            ]
        );

        $this->assertEquals('This is the value', $document->model('repeater1.items.0.text1'));
    }
}
