<?php

namespace GooberBlox\Platform\Groups;

use GooberBlox\Platform\Groups\Models\GroupRoleSet;
use GooberBlox\Platform\Membership\Models\User;
use GooberBlox\Platform\Groups\Models\Group;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class GroupMembership 
{
    public User $user;
    public Group $group;
    public GroupRoleSet $roleSet;

    public function __construct(User $user, Group $group, GroupRoleSet $roleSet)
    {
        $this->user = $user;
        $this->group = $group;
        $this->roleSet = $roleSet;
    }
    
    public function checkedGet(int $groupId, int $userId): GroupMembership
    {
        $group = Group::checkedGetById($groupId);
        $user = User::find($userId);
        return $this->get($group, $user);
    }

    public function get(Group $group, User $user): GroupMembership
    {
        $roleset = GroupRoleSet::getUser($user->id, $group->id);
        return new GroupMembership($user, $group, $roleset);
    }
}
