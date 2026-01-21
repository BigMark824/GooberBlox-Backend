<?php

namespace GooberBlox\Assets\Models;

use Illuminate\Database\Eloquent\Model;
use GooberBlox\Assets\Models\Asset;
class AssetHash extends Model
{
    protected $fillable = [
        'asset_type_id',
        'hash',
        'is_approved',
        'is_reviewed',
        'creator_id'
    ];
}
