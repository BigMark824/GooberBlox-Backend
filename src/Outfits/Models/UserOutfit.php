<?php

namespace GooberBlox\Outfits\Models;

use Illuminate\Database\Eloquent\Model;

class UserOutfit extends Model
{
    protected $fillable = [
        'outfit_id',
        'user_id',
        'name',
        'is_editable'
    ];

    public function outfit()
    {
        return $this->belongsTo(Outfit::class);
    }
}
