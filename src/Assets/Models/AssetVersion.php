<?php

namespace GooberBlox\Assets\Models;

use Illuminate\Database\Eloquent\Model;

class AssetVersion extends Model
{
    protected $fillable = [
        'asset_id',
        'version_number',
        'asset_hash_id',
        'parent_asset_version_id',
        'creator_type',
        'creator_target_id',
        'creating_universe_id'
    ];

    public function asset()
    {
        return $this->hasMany(Asset::class);
    }
}
