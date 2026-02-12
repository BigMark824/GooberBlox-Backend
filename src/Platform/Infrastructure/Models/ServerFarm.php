<?php

namespace GooberBlox\Platform\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class ServerFarm extends Model
{
    protected $fillable = [
        'name',
        'server_type_id',
        'abbreviation'
    ];
}
