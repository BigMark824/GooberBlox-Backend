<?php

namespace GooberBlox\Platform\Avatar;

use GooberBlox\Assets\Models\AssetHash;
use GooberBlox\Outfits\Models\BodyColorSet;

use GooberBlox\Platform\Core\Exceptions\PlatformDataIntegrityException;
use GooberBlox\Platform\Outfits\KeyGeneratorInput;
use GooberBlox\Platform\Outfits\KeyGenerator;

use GooberBlox\Platform\Avatar\Models\UserAvatar;

class AvatarKeyGenerator
{
    private static function computeKey(UserAvatar $avatar, bool $checkIfDefaultClothingNeeded = true): string
    {
        $keyGenerator = new KeyGenerator();
        $input = new KeyGeneratorInput();
        
        $wornAssets = $avatar->getWornAssets($avatar->user_id, $checkIfDefaultClothingNeeded);

        $input->assetIds = array_map(fn($wa) => $wa->assetId, $wornAssets);

        foreach ($wornAssets as $wornAsset) {
            if ($wornAsset->isEquippedGear) {
                $input->equippedGearId = $wornAsset->assetId;
            }
        }

        $bodyColorSetId = BodyColorSet::where('user_id', $avatar->user_id)->first()?->id;

        if ($bodyColorSetId) {
            $bodyColorsHash = $bodyColorSetId;

            if ($bodyColorsHash === null || $bodyColorsHash === '') {
                $input->bodyColorSetId = $bodyColorSetId;
            } else {
                $input->avatarHash = $bodyColorsHash;
            }

            return $keyGenerator->generateKeyUrl($input);
        }

        throw new PlatformDataIntegrityException("UserAvatar for User ID {$avatar->user_id} has a null BodyColorSetID and empty AvatarHash even after getting body colors.");
    }

    public function generateAssetHash(UserAvatar $avatar, bool $checkIfDefaultClothing = true): AssetHash
    {
        (string)$key = self::computeKey($avatar, $checkIfDefaultClothing);
        return KeyGenerator::generateAssetHash($key, $avatar->user_id);
    }
}