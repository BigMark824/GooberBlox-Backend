<?php

namespace GooberBlox\Platform\Membership\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class AccountRoleSet extends Model
{
    use Cachable;
    protected $fillable = [
        'account_id',
        'role_set_id'
    ];

    public function roleSet()
    {
        return $this->belongsTo(RoleSet::class);
    }
}
