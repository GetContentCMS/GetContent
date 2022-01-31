<?php

namespace GetContent\CMS\Tests\Livewire;

use GetContent\CMS\Http\Livewire\FileBrowser;
use GetContent\CMS\Tests\TestCase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

class FileBrowserTest extends TestCase
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
    public function shows_all_current_files(): void
    {
        Livewire::test(FileBrowser::class)
            ->assertSee('Test Image.jpg')
            ->assertSee('Test Doc.pdf');
    }

    /** @test */
    public function shows_current_images(): void
    {
        Livewire::test(FileBrowser::class, ['accept' => 'image/*'])
            ->assertSee('Test Image.jpg')
            ->assertDontSee('Test Doc.pdf');
    }
}
