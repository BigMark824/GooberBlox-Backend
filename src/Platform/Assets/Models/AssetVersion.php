<?php

namespace GooberBlox\Platform\Assets\Models;

use Illuminate\Database\Eloquent\Model;

class AssetVersion extends Model
{
    protected $keyType = 'int';
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
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function assetHash()
    {
        return $this->belongsTo(AssetHash::class, 'asset_hash_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_asset_version_id');
    }
    
}
