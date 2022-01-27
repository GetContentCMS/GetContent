<?php

namespace GetContent\GetContent;

use GetContent\GetContent\Commands\GetContentCommand;
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
            ->hasViews()
            ->hasMigration('create_getcontent_table')
            ->hasCommand(GetContentCommand::class);
    }
}
