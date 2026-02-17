<?php

namespace GooberBlox\Platform\Groups\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use GooberBlox\Platform\Groups\Models\GroupRoleSet;
use Illuminate\Database\Eloquent\Model;

class GroupRoleSetPermission extends Model
{
    use Cachable;
    protected $fillable = [
        'group_role_set_id',
        'role_set_permission_id'
    ];

    protected $casts = [
        'role_set_permission_id' => GroupRoleSetPermissionType::class,
    ];

    public function roleSet()
    {
        return $this->belongsTo(GroupRoleSet::class);
    }
}
