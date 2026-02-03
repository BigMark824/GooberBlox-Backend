<?php

namespace GooberBlox\Assets\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'creator_agent_id',
        'image_asset_id',
        'is_subscribable'
    ];

    public function setItems()
    {
        return $this->hasMany(AssetSetItem::class, 'asset_set_id');
    }
}