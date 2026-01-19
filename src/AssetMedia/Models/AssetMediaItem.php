<?php

namespace GooberBlox\AssetMedia;

use Illuminate\Database\Eloquent\Model;

class AssetMediaItem extends Model
{
    protected $fillable = [
        'asset_id',
        'media_asset_id',
        'uploader_user_id',
        'sort_order'
    ];
}
