<?php

namespace GooberBlox\Platform\Assets\Places\Models;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class PlaceTypes extends Model
{
    use Cachable;
    protected $fillable = [
        'place_type'
    ];

    public function placeAttributes()
    {
        return $this->belongsTo(PlaceAttribute::class, 'place_type_id');
    }
}
