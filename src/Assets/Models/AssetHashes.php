<?php

namespace GooberBlox\Assets\Models;

use Illuminate\Database\Eloquent\Model;
use GooberBlox\Assets\Models\Assets;
class AssetHashes extends Model
{
    protected $fillable = [
        'target_id',
        'hash',
    ];

    public function assets()
    {
        return $this->hasMany(Assets::class, 'target_id');
    }
}
