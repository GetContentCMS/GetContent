<?php

namespace GetContent\CMS;

use GetContent\CMS\Commands\GetContentCommand;
use GetContent\CMS\Facades\GetContent;
use GetContent\CMS\Facades\Nav;
use GetContent\CMS\Fields\ContentField;
use GetContent\CMS\Fields\FileField;
use GetContent\CMS\Fields\ImageField;
use GetContent\CMS\Fields\RepeaterField;
use GetContent\CMS\Fields\SwitchField;
use GetContent\CMS\Fields\TemplateField;
use GetContent\CMS\Fields\TextField;
use GetContent\CMS\Http\Livewire\DocumentBrowser;
use GetContent\CMS\Http\Livewire\DocumentEditor;
use GetContent\CMS\Http\Livewire\FileBrowser;
use GetContent\CMS\View\Composers\GetContentComposer;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GetContentServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('getcontent')
            ->hasConfigFile()
            ->hasViews('gc')
            ->hasViewComposer('*', GetContentComposer::class)
            ->hasMigrations(
                'create_documents_table',
                'create_groups_table',
                'create_templates_table'
            )
            ->hasCommand(GetContentCommand::class);

        $this->publishes(
            ["{$this->getPackageBaseDir()}/../public" => public_path('vendor/getcontent/cms')],
            'getcontent-assets'
        );
    }

    /**
     * @throws \Exception
     */
    public function packageRegistered(): void
    {
        if (config('getcontent.editor_enabled')) {
            Route::prefix(config('getcontent.editor_route'))
                ->middleware('web')->group(function () {
                    Route::get('/browse/{group:uuid?}', DocumentBrowser::class)->name('document:browser');
                    Route::get('/document/{document:uuid}', DocumentEditor::class)->name('document:editor');

                    Route::view('/files', 'gc::editor.file-browser')->name('files:browse');
                });
        }

        $this->app->singleton('GetContent', \GetContent\CMS\GetContent::class);
        $this->app->singleton('Nav', \GetContent\CMS\Editor\Navigation\Nav::class);
        $this->registerFields();
    }

    private function registerFields(): void
    {
        GetContent::registerField('text', TextField::class);
        GetContent::registerField('content', ContentField::class);
        GetContent::registerField('file', FileField::class);
        GetContent::registerField('switch', SwitchField::class);
        GetContent::registerField('template', TemplateField::class);
        GetContent::registerField('repeater', RepeaterField::class);
        GetContent::registerField('image', ImageField::class);
    }

    public function packageBooted(): void
    {
        Livewire::component('file-browser', FileBrowser::class);
        Livewire::component('document-browser', DocumentBrowser::class);
        Livewire::component('document-editor', DocumentEditor::class);

        Nav::create('Documents')
            ->route('document:browser')
            ->icon('heroicon-o-collection');

        Nav::create('Files')
            ->route('files:browse')
            ->icon('heroicon-o-folder-open');
    }
}
