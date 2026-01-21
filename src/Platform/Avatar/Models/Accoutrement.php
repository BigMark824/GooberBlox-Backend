<?php

namespace GooberBlox\Platform\Avatar\Models;

use Illuminate\Database\Eloquent\Model;

use GooberBlox\Platform\AssetOwnership\Models\UserAsset;
class Accoutrement extends Model
{
    protected $fillable = [
        'user_id',
        'user_asset_id'
    ];
    
    public function userAsset()
    {
        return $this->belongsTo(UserAsset::class);
    }
}
