<?php

namespace GooberBlox\Providers;

use Illuminate\Support\ServiceProvider;

class MigrationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../Database/Migrations/' => database_path('migrations'),
        ], 'gooberblox-migrations');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
