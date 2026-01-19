<?php

namespace GooberBlox\Platform\Outfits;

use GooberBlox\Outfits\Models\BodyColorSet;

use GooberBlox\Platform\Outfits\KeyGeneratorInput;
use GooberBlox\Platform\Outfits\KeyGenerator;
use GooberBlox\Assets\Models\Asset;
use GooberBlox\Assets\Enums\AssetType;
class OutfitKeyGenerator
{
    private static function computeKey(array $assetIds, int $bodyColorSetId)
    {
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
        if($bodyColorSetHash.isEmptyOrNullString())
        {   
            $input->bodyColorSetId = $bodyColorSetId;        
        }
        else {
            $input->avatarHash = $bodyColorSetHash;
        }

        return KeyGenerator::GenerateKeyUrl;
    }
}