<?php

namespace GooberBlox\PersonalServers\Models;

use Illuminate\Database\Eloquent\Model;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class PersonalServerRoleset extends Model
{
    use Cachable;

    protected $fillable = [
        'user_id',
        'place_id',
        'rank'
    ];
}
