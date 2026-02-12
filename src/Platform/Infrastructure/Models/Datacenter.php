<?php

namespace GooberBlox\Platform\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class Datacenter extends Model
{
    protected $fillable = [
        'name',
        'vendor_id',
        'latitude',
        'longitude'
    ];
}
