<?php

namespace GooberBlox\Platform\Outfits;

use GooberBlox\Assets\Enums\AssetType;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

use GooberBlox\Platform\Outfits\KeyGeneratorInput;
use GooberBlox\Assets\Models\AssetHash;
use GooberBlox\Assets\Enums\CreatorType;
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
        $assetHash = AssetHash::upload($keyUrl, $userId, AssetType::Avatar);
        return $assetHash;
    }

}