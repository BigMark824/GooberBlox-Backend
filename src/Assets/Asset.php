<?php

namespace GooberBlox\Assets;
use Illuminate\Support\Facades\Cache;

use GooberBlox\Assets\Models\Asset as AssetInstance;
use GooberBlox\Assets\Enums\AssetType;
use GooberBlox\Web\SEO\NameConverter;
class Asset {

    public static function getSEOUrl(AssetInstance $asset) : string
    {
        if($asset == null)
        {
            return "";
        }

        (string)$name = NameConverter::convertToSEO($asset->name);

        if($asset->asset_type_id == AssetType::Place)
        {
            return "/games/{$asset->id}/{$name}";
        }

        return "/catalog/{$asset->id}/{$name}";
    }
}