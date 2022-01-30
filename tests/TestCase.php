<?php

namespace GetContent\CMS\Tests;

use AndreiIonita\BladeRemixIcon\BladeRemixIconServiceProvider;
use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use GetContent\CMS\Facades\GetContent;
use GetContent\CMS\GetContentServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Kalnoy\Nestedset\NestedSetServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\SchemalessAttributes\SchemalessAttributesServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            static fn (string $modelName) => 'GetContent\\CMS\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            SchemalessAttributesServiceProvider::class,
            NestedSetServiceProvider::class,
            BladeIconsServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeRemixIconServiceProvider::class,
            GetContentServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'GetContent' => GetContent::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('app.key', '2QcdGqR8yy45gVjW9k5EivPFazazc4CW');
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/../database/migrations/create_documents_table.php.stub';
        $migration->up();

        $migration = include __DIR__.'/../database/migrations/create_groups_table.php.stub';
        $migration->up();

        $migration = include __DIR__.'/../database/migrations/create_templates_table.php.stub';
        $migration->up();
    }
}
