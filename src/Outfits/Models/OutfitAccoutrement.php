<?php

namespace GooberBlox\Outfits\Models;

use Illuminate\Database\Eloquent\Model;
use GooberBlox\Outfits\Models\Outfit;
class OutfitAccoutrement extends Model
{
    protected $fillable = [
        'outfit_id',
        'asset_id'
    ];

    public function outfit()
    {
        return $this->belongsTo(Outfit::class);
    }
}
