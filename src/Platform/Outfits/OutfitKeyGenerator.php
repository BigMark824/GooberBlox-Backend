<?php

namespace GooberBlox\Platform\Outfits;

use GooberBlox\Outfits\Models\BodyColorSet;

use GooberBlox\Platform\Outfits\KeyGeneratorInput;
use GooberBlox\Platform\Outfits\KeyGenerator;
use GooberBlox\Platform\Assets\Models\Asset;
use GooberBlox\Platform\Assets\Enums\AssetType;
class OutfitKeyGenerator extends KeyGenerator
{
    private static function computeKey(array $assetIds, int $bodyColorSetId)
    {
        $keyGenerator = new KeyGenerator();
        $input = new KeyGeneratorInput();
        sort($assetIds);

        foreach ($assetIds as $assetId) 
        {
            if(Asset::find($assetId)->first()->asset_type_id == AssetType::Gear)
            {
                $input->equippedGearId = $assetId;
            }
        }

        $input->assetIds = $assetIds;

        $bodyColorSetHash = BodyColorSet::find($bodyColorSetId)->body_color_set_hash;
        if (empty($bodyColorSetHash)) {
            $input->bodyColorSetId = $bodyColorSetId;
        } else {
            $input->avatarHash = $bodyColorSetHash;
        }

        return $keyGenerator->generateKeyUrl($input);
    }
}