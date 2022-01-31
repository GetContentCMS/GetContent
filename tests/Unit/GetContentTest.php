<?php

namespace GetContent\CMS\Tests\Unit;

use GetContent\CMS\Facades\GetContent;
use GetContent\CMS\Tests\TestCase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;

class GetContentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake(config('getcontent.file_upload_disk'));

        Storage::drive(config('getcontent.file_upload_disk'))->putFileAs(
            '/',
            File::fake()->image('Test Image.jpg'),
            'Test Image.jpg'
        );
        Storage::drive(config('getcontent.file_upload_disk'))->putFileAs(
            '/',
            File::fake()->create('Test Doc.pdf', 512, 'application/pdf'),
            'Test Doc.pdf'
        );
    }

    /** @test */
    public function lists_files(): void
    {
        $files = GetContent::getFiles()
            ->map(fn ($file) => $file->filename)->flatten()->toArray();

        $this->assertEquals([
            'Test Doc.pdf',
            'Test Image.jpg',
        ], $files);
    }

    /** @test */
    public function only_returns_images(): void
    {
        $files = GetContent::getFiles('image/*')
            ->map(fn ($file) => $file->filename)->flatten()->toArray();

        $this->assertEquals([
            'Test Image.jpg',
        ], $files);
    }
}
