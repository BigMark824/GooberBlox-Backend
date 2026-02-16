<?php

namespace GooberBlox\Platform\Assets\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetSetItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_set_id',
        'asset_target_id',
        'asset_version_id',
        'asset_type_id'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_target_id');
    }

    public function set()
    {
        return $this->belongsTo(AssetSet::class, 'asset_set_id');
    }

    
}