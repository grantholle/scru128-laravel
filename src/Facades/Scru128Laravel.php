<?php

namespace GrantHolle\Scru128Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \GrantHolle\Scru128Laravel\Scru128Laravel
 */
class Scru128Laravel extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \GrantHolle\Scru128Laravel\Scru128Laravel::class;
    }
}
