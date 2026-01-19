<?php

namespace GooberBlox\Features\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureFlags extends Model
{
    protected $fillable = [
        'group',
        'name',
        'value'
    ];
}
