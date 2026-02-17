<?php

namespace GooberBlox\Platform\Universes;

use GooberBlox\Platform\Core\Enums\CreatorType;
use GooberBlox\Platform\Core\Exceptions\PlatformArgumentException;
use GooberBlox\Platform\Groups\Enums\GroupRoleSetPermissionType;
use GooberBlox\Platform\Groups\GroupMembership;
use GooberBlox\Platform\Universes\Models\Universe;
use GooberBlox\Platform\Membership\Models\User;
use InvalidArgumentException;

class UniversePermissionsVerifier {
    private readonly GroupMembership $groupMembership;

    public function __construct(GroupMembership $groupMembershipFactory)
    {
        $this->groupMembership = $groupMembership ?? throw new InvalidArgumentException("groupMembership");
    }

    public function canUserManageUniverse(User $user, Universe $universe) : bool
    {
        if(!$user)
            throw new PlatformArgumentException("user");

        if(!$universe)
            throw new PlatformArgumentException("universe");

        if($universe->creator_type == CreatorType::User)
        {
            return $universe->creator_target_id == $user->id;
        }

        if($universe->creator_type == CreatorType::Group)
        {
            return $this->groupMembership->checkedGet($universe->creator_target_id, $user->id)->roleSet->hasPermission(GroupRoleSetPermissionType::CanManageGroupGames);
        }

        return false;
    }

    // Currently returns false as PermissionResolution is the new method for this
    // please see Roblox.Platform.Universes.UniversePermissionsVerifier line 47
    public function canUserPlayUniverse(User $user, Universe $universe) : bool
    {
        if(!$user)
            throw new PlatformArgumentException("user");

        if(!$universe)
            throw new PlatformArgumentException("universe");

        return false;
    }
}