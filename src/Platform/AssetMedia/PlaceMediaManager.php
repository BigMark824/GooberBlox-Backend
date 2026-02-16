<?php

namespace GooberBlox\Platform\AssetMedia;

use GooberBlox\Assets\Enums\AssetType;
use GooberBlox\Assets\Places\Models\PlaceAttribute;
use Illuminate\Support\Collection;
class PlaceMediaManager
{
    protected $maximumPlaceMediaItems = config('gooberblox.assetmedia.MaximumPlaceMediaItemsPerPlace');
    private static function _setUsePlaceMediaForThumbs(int $placeId, bool $usePlaceMedia): void
    {
        $placeAttribute = PlaceAttribute::getOrCreate([
            'place_id' => $placeId,
        ]);

        $placeAttribute->use_place_media_for_thumb = $usePlaceMedia;
        $placeAttribute->save();
    }
    private static function _usesPlaceMediaForThumbs(int $placeId) : bool
    {
        return PlaceAttribute::where('place_id', $placeId)
            ->value('use_place_media_for_thumb') ?? false;
    }
    public static function addPlaceMedia(int $placeId, int $uploadedMediaAssetId, $uploaderUserId, ?AssetType $assetType = null) : AssetMediaItem
    {
        $mediaItems = PlaceMediaItem::where('asset_id', $placeId)
            ->orderBy('sort_order')
            ->get();

        $newPrimary = AssetMediaItem::create([
            'asset_id' => $placeId,
            'uploaded_media_asset_id' => $uploadedMediaAssetId,
            'uploader_user_id' => $uploaderUserId
        ]);

        for ($i = self::$maximumPlaceMediaItems - 1; $i < $mediaItems->count(); $i++) {
            $mediaItems[$i]->delete();
        }

        foreach ($mediaItems as $item) {
            $item->increment('sort_order');
        }

        self::_setUsePlaceMediaForThumbs($placeId, usePlaceMedia: true);
        return $newPrimary;
    }

    public static function getPlaceMediaItemsByPlaceID(int $placeId) : Collection
    {
        if (self::_usesPlaceMediaForThumbs($placeId)) {
            return PlaceMediaItem::where('place_id', $placeId)
                ->orderBy('sort_order')
                ->limit(config('gooberblox.assetmedia.Default.MaximumPlaceMediaItemsPerPlace'))
                ->get();
        }

        return collect();
    }

    public static function getTotalNumberOfPlaceMediaItemsByPlaceID(int $placeId) : int
    {
        if(self::_usesPlaceMediaForThumbs($placeId))
        {
            return PlaceMediaItem::where('place_id', $placeId)->count();
        }

        return 0;
    }

    public static function deletePlaceMedia(int $placeMediaItemid)
    {
        $mediaItem = PlaceMediaItem::find($placeMediaItemid);
        $mediaItem->delete();

        if(self::getTotalNumberOfPlaceMediaItemsByPlaceID($mediaItem->place_id) === 0)
        {
            self::_setUsePlaceMediaForThumbs($mediaItem->place_id, usePlaceMedia: false);
        }
    }
}
