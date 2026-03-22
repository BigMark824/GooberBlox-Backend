<?php

namespace GooberBlox\Account\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use GooberBlox\Account\Models\AccountStatus;
use GooberBlox\Platform\Membership\Models\User;
use GooberBlox\Platform\Membership\Models\RoleSet;

/**
 * Outlines the Account model class
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $accountStatusId
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * Relationships
 * @property-read User|null $user
 * @property-read AccountStatus|null $accountStatus
 * @property-read Collection<int, RoleSet> $roleSets
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereName(string $value)
 */
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
    /**
     * Returns the accounts associated user
     * @return HasOne<User, Account>
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class,'account_id');
    }
    /**
     * Returns the accounts associated account-status
     * @return BelongsTo<AccountStatus, Account>
     */
    public function accountStatus(): BelongsTo
    {
        return $this->belongsTo(AccountStatus::class, 'account_status_id'); 
    }
    /**
     * Returns the accounts rolesets
     * @return BelongsToMany<RoleSet, Account, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function roleSets(): BelongsToMany
    {
        return $this->belongsToMany(
            RoleSet::class,
                'account_role_sets',
                'account_id',
                'role_set_id'
            )->withTimestamps();
    }
    /**
     * Returns if a user is in a specified roleset
     * @param int $roleSetId
     * @return bool
     */
    public function isInRole(int $roleSetId): bool
    {
        return $this->roleSets->contains('id', $roleSetId);
    }
    /**
     * Returns the highest role set available for the user
     * @return RoleSet
     */
    public function highestRoleSet(): RoleSet
    {
        return $this->roleSets->sortByDesc('rank')->first();
    }
    /**
     * Returns all the role set names
     * @return array
     */
    public function roleSetNames(): array
    {
        return $this->roleSets
            ->sortByDesc('rank')
            ->pluck('name')
            ->toArray();
    }
}
