<?php

namespace Gooberblox\Platform\Assets;

use GooberBlox\Assets\Models\Asset;
use GooberBlox\Assets\Exceptions\UnknownAssetException;
use GooberBlox\Assets\Enums\AssetType;
use GooberBlox\Platform\Universes\Models\Universe;
use GooberBlox\Assets\Places\Models\PlaceAttribute;
use GooberBlox\Membership\Models\User;

class Place {
    public Asset $asset;

    public function __construct(int $assetId)
    {
        $asset = Asset::find($assetId);

        if (!$asset) {
            throw new UnknownAssetException($assetId);
        }

        if ($asset->asset_type_id !== AssetType::Place) {
            throw new \InvalidArgumentException("Asset {$assetId} is not of AssetType Place");
        }

        $this->asset = $asset;
    }
}