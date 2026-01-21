<?php

namespace GooberBlox\Providers;

use GooberBlox\Services\FilesManager;
use Illuminate\Support\ServiceProvider;

class GooberBloxServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishesMigrations([
            __DIR__ . '/../Database/Migrations/' => database_path('migrations'),
        ], 'gooberblox-migrations');
        $this->publishes([
            __DIR__ . '/../Database/Seeders/' => database_path('seeders'),
        ], 'gooberblox-seeders');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        if ($this->app->runningInConsole()) {
            $this->commands([
                \GooberBlox\Console\Commands\ImportFeatureFlags::class,
            ]);
        }
        
        $this->app->singleton(FilesManager::class, function ($app) {
            return FilesManager::singleton();
        });
    }
}
