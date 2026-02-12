<?php

namespace GooberBlox\Platform\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class ServerGroupMember extends Model
{
    protected $fillable = [
        'server_id',
        'server_group'
    ];
}
