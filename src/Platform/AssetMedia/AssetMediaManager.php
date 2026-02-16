<?php

namespace GooberBlox\Platform\AssetMedia;

use GooberBlox\Platform\Assets\Enums\AssetType;
class AssetMediaManager
{
    public static function addAssetMedia(int $assetId, int $uploadedMediaAssetId, $uploaderUserId, ?AssetType $assetType = null) : AssetMediaItem
    {
        $mediaItems = AssetMediaItem::where('asset_id', $assetId)
            ->orderBy('sort_order')
            ->get();

        $newPrimary = AssetMediaItem::create([
            'asset_id' => $assetId,
            'uploaded_media_asset_id' => $uploadedMediaAssetId,
            'uploader_user_id' => $uploaderUserId
        ]);

        $maxMedia = self::getMaximumAssetMedia($assetType);

        for ($i = $maxMedia - 1; $i < $mediaItems->count(); $i++) {
            $mediaItems[$i]->delete();
        }

        foreach ($mediaItems as $item) {
            $item->increment('sort_order');
        }

        return $newPrimary;
    }
    private static function getMaximumAssetMedia(?AssetType $assetType = null) : int
    {
        if($assetType === null)
        {
            return config('gooberblox.assetmedia.Default.MaximumPlaceMediaItemsPerPlace');
        }

        $value = $assetType->value; 
        if($value == AssetType::Plugin)
        {
            return config('gooberblox.assetmedia.Default.MaximumPluginAssetMediaCount');
        }

        return config('gooberblox.assetmedia.Default.MaximumPlaceMediaItemsPerPlace');
    }
}
