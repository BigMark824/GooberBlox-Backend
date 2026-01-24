<?php

namespace GooberBlox\Platform\Avatar\Models;

use Illuminate\Database\Eloquent\Model;

use GooberBlox\Platform\AssetOwnership\Models\UserAsset;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class Accoutrement extends Model
{
    use Cachable;
    protected $fillable = [
        'user_id',
        'user_asset_id'
    ];  
    
    public function userAsset()
    {
        return $this->belongsTo(UserAsset::class);
    }

}
