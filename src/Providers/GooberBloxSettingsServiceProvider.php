<?php

namespace GooberBlox\Providers;

use Illuminate\Support\ServiceProvider;

class GooberBloxSettingsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../AssetMedia/Properties/settings.php',
            'gooberblox.assetmedia'
        );
        $this->mergeConfigFrom(
            __DIR__ . '/../Platform/TeamCreate/Properties/settings.php',
            'gooberblox.teamcreate'
        );
        $this->mergeConfigFrom(
            __DIR__ . '/../Users/Properties/settings.php',
            'gooberblox.users'
        );
    }
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../AssetMedia/Properties/settings.php' => config_path('gooberblox/assetmedia.php'),
            __DIR__ . '/../Users/Properties/settings.php' => config_path('gooberblox/users.php'),
        ], 'gooberblox-config');
        
    }
}
