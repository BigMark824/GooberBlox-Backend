<?php

namespace GooberBlox\Assets\Models;

use Illuminate\Database\Eloquent\Model;
use GooberBlox\Assets\Models\Asset;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class AssetHash extends Model
{
    use Cachable;
    protected $fillable = [
        'asset_type_id',
        'hash',
        'is_approved',
        'is_reviewed',
        'creator_id',
        'creator_type'
    ];

}
