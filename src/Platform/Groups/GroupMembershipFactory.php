<?php

namespace GooberBlox\Platform\Groups;

use GooberBlox\Platform\Groups\Models\GroupRoleSet;
use GooberBlox\Platform\Membership\Models\User;
use GooberBlox\Platform\Groups\Models\Group;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class GroupMembershipFactory
{
    public function checkedGet(int $groupId, int $userId): GroupMembership
    {
        $group = Group::checkedGetById($groupId);
        $user = User::find($userId);
        return $this->get($group, $user);
    }

    public function get(mixed $groupOrId, mixed $userOrId): GroupMembership
    {
        $group = $groupOrId instanceof Group ? $groupOrId : Group::checkedGetById($groupOrId);
        $user = $userOrId instanceof User ? $userOrId : User::findOrFail($userOrId);

        $roleset = GroupRoleSet::getUser($user->id, $group->id);

        return new GroupMembership($user, $group, $roleset);
    }

}
