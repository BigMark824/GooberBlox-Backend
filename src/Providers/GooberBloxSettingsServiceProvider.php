<?php

namespace GooberBlox\Providers;

use Illuminate\Support\ServiceProvider;

class GooberBloxSettingsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Platform/AssetMedia/Properties/settings.php',
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
        $this->mergeConfigFrom(
            __DIR__ . '/../Common/Properties/settings.php',
            'gooberblox.common'
        );
        $this->mergeConfigFrom(
            __DIR__ . '/../Platform/Universes/Properties/settings.php',
            'gooberblox.universes'
        );
        $this->mergeConfigFrom(
            __DIR__ . '/../Library/Properties/settings.php',
            'gooberblox.class-library'
        );
    }
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../Platform/AssetMedia/Properties/settings.php' => config_path('gooberblox/assetmedia.php'),
            __DIR__ . '/../Users/Properties/settings.php' => config_path('gooberblox/users.php'),
            __DIR__ . '/../Common/Properties/settings.php' => config_path('gooberblox/common.php'),
            __DIR__ . '/../Platform/Universes/Properties/settings.php' => config_path('gooberblox/universes.php'),
            __DIR__ . '/../Library/Properties/settings.php' => config_path('gooberblox/settings.php'),
        ], 'gooberblox-config');
        
    }
}
