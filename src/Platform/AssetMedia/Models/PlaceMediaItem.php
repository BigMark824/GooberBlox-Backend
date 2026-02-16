<?php

namespace GooberBlox\Platform\AssetMedia;

use Illuminate\Database\Eloquent\Model;

class PlaceMediaItem extends Model
{
    protected $fillable = [
        'place_id',
        'media_asset_id',
        'uploader_user_id',
        'sort_order'
    ];
}
