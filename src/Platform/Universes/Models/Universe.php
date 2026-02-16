<?php

namespace GooberBlox\Platform\Universes\Models;

use Illuminate\Database\Eloquent\Model;
use GooberBlox\Platform\Assets\Models\Asset;
use GooberBlox\Platform\Assets\Place;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Universe extends Model
{
    use Cachable;
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
       
    public static function getPlaceUniverse(Place $place)
    {
        return $place->asset->universe;
    }

}

