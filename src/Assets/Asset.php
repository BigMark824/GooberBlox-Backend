<?php

namespace GooberBlox\Assets;
use Illuminate\Support\Facades\Cache;

use GooberBlox\Assets\Models\Asset as AssetModel;
use GooberBlox\Assets\Enums\AssetType;
use GooberBlox\Assets\Exceptions\UnknownAssetException;

use Illuminate\Support\Facades\{Storage, Log};
class Asset {

    protected $assetId;
    public function __construct($assetId)
    {
        $this->assetId = $assetId;
    }

}