<?php

namespace GooberBlox\Platform\Avatar;

use GooberBlox\Platform\Avatar\Models\Accoutrement;
use Illuminate\Database\Eloquent\Model;

class UserAvatar extends Model
{
    protected $fillable = [
        'user_id',
        'new_avatar_asset_hash_id',
        'body_color_set_id'
    ];

    public function getWornAssets(int $userId, bool $checkIfDefaultClothingNeeded, ?bool $mustCheckWearingRules = false) 
    {
        $accoutrements = Accoutrement::where('user_id', $userId)->get();
        $wornAssets = [];

        foreach ($accoutrements as $acc) {
            $userAsset = $acc->userAsset;

            $isGear = $userAsset->$isGear();
            $isAnimation = $userAsset->$isAnimation();
            $assetId = $userAsset->$assetId;
            
            $wornAssets[] = new WornAsset(
                $userAsset->user_asset_id,
                $assetId,
                $isGear,
                $isGear,
                $isAnimation,
                $userAsset->asset_type_id  
            );

        }

        if($checkIfDefaultClothingNeeded)
        {
            $wornAssets = $this->addDefaultClothing($wornAssets, $this);
        }

        return $wornAssets;
    }

    public function addDefaultClothing(array $wornAssets, UserAvatar $avatar): array
    {
        // todo

        return [];
    }
}
