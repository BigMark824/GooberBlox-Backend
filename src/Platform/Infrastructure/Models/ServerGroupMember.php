<?php

namespace GooberBlox\Platform\Infrastructure\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class ServerGroupMember extends Model
{
    use Cachable;
    protected $fillable = [
        'server_id',
        'server_group'
    ];
}
