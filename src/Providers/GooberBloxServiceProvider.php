<?php

namespace GooberBlox\Providers;

use Illuminate\Support\ServiceProvider;

class GooberBloxServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../AssetMedia/Properties/settings.php',
            'gooberblox.assetmedia'
        );
    }
    public function boot(): void
    {
        $this->publishesMigrations([
            __DIR__ . '/../Database/Migrations/' => database_path('migrations'),
        ], 'gooberblox-migrations');
        $this->publishes([
            __DIR__ . '/../Database/Seeders/' => database_path('seeders'),
        ], 'gooberblox-seeders');
        $this->publishes([
            __DIR__ . '/../AssetMedia/Properties/settings.php' => config_path('gooberblox/assetmedia.php'),
        ], 'gooberblox-config');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        if ($this->app->runningInConsole()) {
            $this->commands([
                \GooberBlox\Console\Commands\ImportFeatureFlags::class,
            ]);
        }
        
    }
}
