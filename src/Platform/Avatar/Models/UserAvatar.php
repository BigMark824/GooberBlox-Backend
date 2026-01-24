<?php

namespace GooberBlox\Platform\Avatar\Models;

use GooberBlox\Platform\Avatar\Models\Accoutrement;
use GooberBlox\Platform\Avatar\WornAsset;
use GooberBlox\Assets\Enums\AssetType;

use Illuminate\Database\Eloquent\Model;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class UserAvatar extends Model
{
    use Cachable;
    protected $fillable = [
        'user_id',
        'new_avatar_asset_hash_id',
        'body_color_set_id'
    ];

    public function getWornAssets(int $userId, bool $checkIfDefaultClothingNeeded, ?bool $mustCheckWearingRules = false) 
    {
        $accoutrements = Accoutrement::where('user_id', $userId)->get();
        $wornAssets = [];

        foreach ($accoutrements as $acc) 
        {
            $userAsset = $acc->userAsset;

            if($userAsset != null)
            {
                $isGear = $userAsset->isGear();
                $isAnimation = $userAsset->isAnimation();
                $assetId = $userAsset->asset_id;
                
                $wornAssets[] = new WornAsset(
                    assetTypeId: $userAsset->asset_type_id,
                    assetId: $assetId,
                    isEquippedGear: $isGear,
                    isGear: $isGear,
                    isAnimation: $isAnimation,
                );
            }
        }

        if($checkIfDefaultClothingNeeded)
        {
            $wornAssets = $this->addDefaultClothing($wornAssets);
        }

        return $wornAssets;
    }

    public function addDefaultClothing(array $wornAssets): array
    {
        // TODO: THIS IS TEMPORARY
        $defaultAssetIds = [451212192, 12868365141, 48474313, 8561741];

        foreach ($defaultAssetIds as $assetId) {
            $wornAssets[] = new WornAsset(
                assetId: $assetId, 
                isEquippedGear: false, 
                isGear: false,
                isWearable: true,      
                isAnimation: false,   
                assetTypeId: AssetType::Shirt->value,    // TODO: temporary
            );
        }

        return $wornAssets;
    }
}
