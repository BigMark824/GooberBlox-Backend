<?php

namespace GooberBlox\Platform\TeamCreate\Models;

use Illuminate\Database\Eloquent\Model;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class TeamCreateMembership extends Model
{
    /*
        This class is not remotely accurate but this is Laravel, 
        I dont need to reinvent the wheel for TC editors

        - Harley
    */
    use Cachable;
    protected $fillable = [
        'universe_id',
        'user_id',
    ];
}
