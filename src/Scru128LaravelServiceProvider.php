<?php

namespace GrantHolle\Scru128Laravel;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class Scru128LaravelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('scru128-laravel');
    }

    public function packageBooted(): void
    {
        Blueprint::macro('scru128', function (string $column = 'id'): ColumnDefinition {
            /** @var Blueprint $this */
            return $this->char($column, 25)->primary();
        });

        Blueprint::macro('foreignScru128', function (string $column): ForeignIdColumnDefinition {
            /** @var Blueprint $this */
            $definition = new ForeignIdColumnDefinition($this, [
                'type' => 'char',
                'name' => $column,
                'length' => 25,
            ]);

            $this->addColumnDefinition($definition);

            return $definition;
        });
    }
}
