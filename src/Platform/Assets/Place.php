<?php

namespace GooberBlox\Platform\Assets;

use GooberBlox\Assets\Models\Asset;
use GooberBlox\Assets\Exceptions\UnknownAssetException;
use GooberBlox\Assets\Enums\AssetType;
use GooberBlox\Platform\Universes\Models\Universe;

class Place {
    public Asset $asset;

    public function __construct(?int $assetId)
    {
        $asset = Asset::find($assetId);

        if (!$asset) {
            throw new UnknownAssetException($assetId);
        }

        if ($asset->asset_type_id !== AssetType::Place->value) {
            throw new \InvalidArgumentException("Asset {$assetId} is not of AssetType Place");
        }

        $this->asset = $asset;
    }

    public function __get($key)
    {
        return $this->asset->$key ?? null;
    }

    public function universe(): ?Universe
    {
        return $this->asset->universe()->first();
    }
}