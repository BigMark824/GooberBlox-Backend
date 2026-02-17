<?php

namespace GooberBlox\Platform\Groups\Models;

use Illuminate\Database\Eloquent\Model;

class GroupRoleSet extends Model
{
    protected $fillable = [
        'name',
        'description',
        'rank',
        'group_id'
    ];
}
