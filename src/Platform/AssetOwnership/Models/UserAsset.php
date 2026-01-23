<?php

namespace GooberBlox\Platform\AssetOwnership\Models;

use Illuminate\Database\Eloquent\Model;

use GooberBlox\Assets\Models\Asset;
use GooberBlox\Assets\Enums\AssetType;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class UserAsset extends Model
{
    use Cachable;
    protected $fillable = [
        'asset_id', 
        'asset_type_id',
        'user_id'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function isGear(): bool
    {
        return $this->asset_type_id === AssetType::Gear;
    }

    public function isAnimation(): bool
    {
        return $this->asset_type_id === AssetType::Animation;
    }
}
