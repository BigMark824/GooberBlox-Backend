<?php

namespace GooberBlox\Library\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use Cachable;
    protected $fillable = [
        'user_id',
        'group_id',
        'role_set_id',
        'is_top_group'
    ];
}
