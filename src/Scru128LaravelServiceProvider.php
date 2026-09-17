<?php

namespace GrantHolle\Scru128Laravel;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;
use Illuminate\Support\ServiceProvider;

class Scru128LaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
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
