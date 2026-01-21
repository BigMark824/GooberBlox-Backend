<?php

namespace GooberBlox\Platform\Outfits;

use GooberBlox\Assets\Enums\AssetType;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

use GooberBlox\Platform\Outfits\KeyGeneratorInput;
use GooberBlox\Assets\Models\AssetHash;
use GooberBlox\Services\FilesManager;
class KeyGenerator
{
    // For more information see Roblox.Platform.Outfits.KeyGenerator
    public function generateKeyUrl(KeyGeneratorInput $generatorInput): string
    {
        $url = URL::to('/Asset/AvatarAccoutrements.ashx') . '?';

        if (!empty($generatorInput->avatarHash)) {
            $url .= 'AvatarHash=' . $generatorInput->avatarHash;
        } else {
            $url .= 'BodyColorSetID=' . $generatorInput->bodyColorSetId;
        }

        $assetIds = $generatorInput->assetIds;
        sort($assetIds, SORT_NUMERIC);

        $url .= '&AssetIDs=' . implode(',', $assetIds);

        if (!empty($generatorInput->equippedGearId) && $generatorInput->equippedGearId !== 0) {
            $url .= '&EquippedGearID=' . $generatorInput->equippedGearId;
        }

        return $url;
    }


    public static function generateAssetHash(string $keyUrl, int $userId): AssetHash
    {
        (string)$hash = FilesManager::singleton()->addFile($keyUrl);

        return $assetHash = AssetHash::create([
            'asset_type_id' => AssetType::Avatar,
            'hash' => $hash,
            'creator_id' => $userId,
            'creator_type' => \GooberBlox\Assets\Enums\CreatorType::User
        ]);
        
    }

}