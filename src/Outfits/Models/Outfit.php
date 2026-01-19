<?php

namespace GooberBlox\Outfits\Models;

use Illuminate\Database\Eloquent\Model;

use GooberBlox\Outfits\Models\OutfitAccoutrement;
class Outfit extends Model
{
    protected $fillable = [
        'asset_hash_id',
        'body_color_set_id'
    ];

    public function accoutrement()
    {
        return $this->hasMany(OutfitAccoutrement::class);
    }

    public function userOutfit()
    {
        return $this->hasMany(UserOutfit::class);
    }
}
