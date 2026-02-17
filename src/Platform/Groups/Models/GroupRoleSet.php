<?php

namespace GooberBlox\Platform\Groups\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use GooberBlox\Library\Models\UserGroup;
use GooberBlox\Platform\Groups\Enums\GroupRoleSetPermissionType;
use Illuminate\Database\Eloquent\Model;

class GroupRoleSet extends Model
{
    use Cachable;
    private const GUEST_RANK = 0;
    private const OWNER_RANK = 255;
    protected $fillable = [
        'name',
        'description',
        'rank',
        'group_id'
    ];

    public function isGuest(): bool
    {
        return $this->rank === self::GUEST_RANK;
    }

    public function isOwner(): bool
    {
        return $this->rank === self::OWNER_RANK;
    }

    public function hasPermission(GroupRoleSetPermissionType $permission) : bool
    {
        $group = Group::find($this->group_id);
        if(!$group || $group->isLocked())
        {
            return false;
        }

        return GroupRoleSetPermission::where('group_role_set_id', $this->id)
            ->where('role_set_permission_id', $permission->value)
            ->exists();
    }

    public static function getUser(?int $userId, int $groupId): GroupRoleSet
    {
        if(!$userId)
        {
            return self::getGuestRoleSet($groupId);
        }

        $ug = UserGroup::where('user_id', $userId)
                    ->where('group_id', $groupId)
                    ->first();

        if(!$ug)
        {
            return self::getGuestRoleSet($groupId);
        }

        return self::find($ug->role_set_id);
    }

    public static function getGuestRoleSet(int $groupId) : GroupRoleSet
    {
        return self::where('group_id', $groupId)->where('name', "Guest")->first();
    }

}
