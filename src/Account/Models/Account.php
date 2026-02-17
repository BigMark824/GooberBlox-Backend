<?php

namespace GooberBlox\Account\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use GooberBlox\Library\Models\RoleSet;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use GooberBlox\Account\Enums\AccountStatusEnum;
use GooberBlox\Account\Models\AccountStatus;

class Account extends Authenticatable
{
    use Cachable;
    use Notifiable;

    protected $table = 'accounts';
    protected $fillable = [
        'name',
        'description',
        'password',
        'account_status_id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function user()
    {
        return $this->hasOne(\GooberBlox\Platform\Membership\Models\User::class,'account_id');
    }
    public function accountStatus()
    {
        return $this->belongsTo(AccountStatus::class, 'account_status_id'); 
    }

    public function roleSets()
    {
        return $this->belongsToMany(
            \GooberBlox\Platform\Membership\Models\RoleSet::class,
            'account_role_sets',
            'account_id',
            'role_set_id'
        )->withTimestamps();
    }

    public function isInRole(int $roleSetId): bool
    {
        return $this->roleSets->contains('id', $roleSetId);
    }

    public function highestRoleSet()
    {
        return $this->roleSets->sortByDesc('rank')->first();
    }

    public function roleSetNames(): array
    {
        return $this->roleSets
            ->sortByDesc('rank')
            ->pluck('name')
            ->toArray();
    }


}
