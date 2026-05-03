<?php

namespace GooberBlox\Platform\Assets;

use GooberBlox\Platform\Assets\Models\Asset;
use GooberBlox\Platform\Assets\Exceptions\UnknownAssetException;
use GooberBlox\Platform\Assets\Enums\AssetType;
use GooberBlox\Platform\Assets\Places\Models\PlaceAttribute;
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
    public static function forCreator(int $creatorId)
    {
        return Asset::where('asset_type_id', AssetType::Place->value)
            ->where('creator_id', $creatorId)
            ->get()
            ->map(fn ($asset) => new self($asset->id));
    }
    public function __get($key)
    {
        return $this->asset->$key ?? null;
    }
    public function __call($method, $args)
    {
        return $this->asset->$method(...$args);
    }
    public function universe(): ?Universe
    {
        return $this->asset->universe;
    }

    public function attribute(): ?PlaceAttribute
    {
        return $this->asset->placeAttribute;
    }
}