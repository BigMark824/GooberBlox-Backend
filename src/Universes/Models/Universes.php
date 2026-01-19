<?php

namespace GooberBlox\Universes\Models;

use Illuminate\Database\Eloquent\Model;
use GooberBlox\Assets\Models\Asset;
class Universes extends Model
{
    protected $fillable = [
        'name',
        'description',
        'creator_target_id',
        'root_place_id',
        'privacy_type',
        'is_archived',
        'creator_type',
        'api_services',
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'universe_id');
    }
}
