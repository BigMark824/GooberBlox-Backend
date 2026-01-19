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
    }
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../AssetMedia/Properties/settings.php' => config_path('gooberblox/assetmedia.php'),
        ], 'gooberblox-config');
        
    }
}
