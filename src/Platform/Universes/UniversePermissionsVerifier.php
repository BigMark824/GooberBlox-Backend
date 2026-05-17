<?php

namespace GooberBlox\Platform\Universes;

use GooberBlox\Platform\Assets\Enums\CreatorType;
use GooberBlox\Platform\Core\Exceptions\PlatformArgumentException;
use GooberBlox\Platform\Groups\Enums\GroupRoleSetPermissionType;
use GooberBlox\Platform\Groups\GroupMembershipFactory;
use GooberBlox\Platform\Universes\Models\Universe;
use GooberBlox\Platform\Membership\Models\User;
use InvalidArgumentException;

class UniversePermissionsVerifier {
    private readonly GroupMembershipFactory $groupMembershipFactory;

    public function __construct(GroupMembershipFactory $groupMembershipFactory)
    {
        $this->groupMembershipFactory = $groupMembershipFactory ?? throw new InvalidArgumentException("groupMembershipFactory");
    }

    public function canUserManageUniverse(User $user, Universe $universe) : bool
    {
        if (! $user) {
            throw new PlatformArgumentException("user");
        }

        if (! $universe) {
            throw new PlatformArgumentException("universe");
        }

        $creatorType = $universe->creator_type instanceof CreatorType
            ? $universe->creator_type
            : CreatorType::tryFrom((int) $universe->creator_type);

        if ($creatorType === CreatorType::User) {
            return (int) $universe->creator_target_id === (int) $user->id;
        }

        if ($creatorType === CreatorType::Group) {
            return $this->groupMembershipFactory
                ->checkedGet($universe->creator_target_id, $user->id)
                ->roleSet
                ->hasPermission(GroupRoleSetPermissionType::CanManageGroupGames);
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
