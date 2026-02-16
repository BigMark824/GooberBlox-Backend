<?php

namespace GooberBlox\Platform\AssetMedia;

use Illuminate\Database\Eloquent\Model;

class PlaceIcon extends Model
{
    protected $fillable = [
        'place_id',
        'image_id',
    ];
}
