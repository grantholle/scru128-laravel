<?php

namespace GrantHolle\Scru128Laravel\Commands;

use Illuminate\Console\Command;

class Scru128LaravelCommand extends Command
{
    public $signature = 'scru128-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
