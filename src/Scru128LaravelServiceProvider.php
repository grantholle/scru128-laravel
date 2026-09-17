<?php

namespace GrantHolle\Scru128Laravel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use GrantHolle\Scru128Laravel\Commands\Scru128LaravelCommand;

class Scru128LaravelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('scru128-laravel')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_scru128_laravel_table')
            ->hasCommand(Scru128LaravelCommand::class);
    }
}
