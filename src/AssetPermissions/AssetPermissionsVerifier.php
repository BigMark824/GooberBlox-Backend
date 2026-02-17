<?php

namespace GooberBlox\Platform\AssetPermissions;

use Exception;
use GooberBlox\Platform\Assets\Enums\AssetType;
use GooberBlox\Platform\Assets\Models\AssetOption;
use GooberBlox\Platform\Assets\Place;
use GooberBlox\Platform\Universes\UniversePermissionsVerifier;
use GooberBlox\Platform\Groups\GroupMembership;
use GooberBlox\Platform\Membership\Models\User;
use GooberBlox\Platform\Universes\Models\Universe;
use InvalidArgumentException;
use Log;

class AssetPermissionsVerifier {
    private readonly GroupMembership $groupMembership;
    private readonly Universe $universe;
    private readonly UniversePermissionsVerifier $universePermissionsVerifier;
    private const UNIVERSE_RESOURCE_TYPE = 'Universe';
    private const ADMIN_ACTION = 'Admin';

    public function __construct(GroupMembership $groupMembership, Universe $universe, UniversePermissionsVerifier $universePermissionsVerifier)
    {
        $this->groupMembership = $groupMembership ?? throw new InvalidArgumentException("groupMembership");
        $this->universe = $universe ?? throw new InvalidArgumentException("universe");
        $this->universePermissionsVerifier = $universePermissionsVerifier ?? throw new InvalidArgumentException("universePermissionsVerifier");
    }

    public function isOwner(User $user, \GooberBlox\Platform\Assets\Models\Asset $asset): bool
    {
        if($user == null)
            throw new InvalidArgumentException("user");

         if($asset == null)
            throw new InvalidArgumentException("asset");      
        
        return match($asset->creator_type) {
            'User' => $asset->creator_target?->id === $user->id,
            'Group' => (fn() => 
                        $this->groupMembership->checkedGet(
                            $asset->creator_target?->id,
                            $user->id
                        )->roleSet->isOwner())(),
            default => false,
        };
    }

    public function canManage(User $user, \GooberBlox\Platform\Assets\Models\Asset $asset) : bool
    {
        if($user == null)
            throw new InvalidArgumentException("user");

        if($asset == null)
            throw new InvalidArgumentException("asset");      

        if($asset->asset_type_id == AssetType::Place)
        {
            if($asset->universe)
            {
                return $this->universePermissionsVerifier->canUserManageUniverse($user, $asset->universe);
            }
        }

        return match($asset->creator_type) {
            'User' => $asset->creator_target?->id === $user->id,
            'Group' => (fn() => 
                        $this->groupMembership->checkedGet(
                            $asset->creator_target?->id,
                            $user->id
                        )->roleSet->isOwner())(),
            default => false,
        };
    }

    public function canEdit(User $user, Place $place) : bool
    {
        if($place == null)
        {
            throw new InvalidArgumentException("place");
        }

        if(!$this->isCopyLocked($place))
        {
            return true;
        }

        if($user == null)
        {
            throw new InvalidArgumentException("user");
        }

        if($place->asset->creator_type == \GooberBlox\PlatForm\Assets\Enums\CreatorType::User && $user->id == $place->asset->creator_target->id)
        {
            return true;
        }

        return $this->canManage($user, $place->asset);
    }
    
    public function canPlay(User $user, Place $place) : bool
    {
        if($user == null)
            throw new InvalidArgumentException("user");

        if($place == null)
            throw new InvalidArgumentException("place");

        if($place->universe)
        {
            return $this->universePermissionsVerifier->canUserPlayUniverse($user, $place->universe);
        }

        Log::error("No universe found for place with ID: {$place->id}");
        return false;
    }

    public function tryCanManage(User $user, Place $place) : bool
    {
        $success = false;
        $canManage = false;
        try {
            $canManage = $this->canManage($user, $place->asset);
            return true;
        } catch(Exception $e)
        {
            Log::error("There was an exception while calling CanManage() :{$e->getMessage()}");
            return false;
        }
    }

    public function tryCanEdit(User $user, Place $place) : bool
    {
        $success = false;
        $canEdit = false;
        try {
            $canEdit = $this->canEdit($user, $place);
            return true;
        } catch(Exception $e)
        {   
            // fun piece of trivia, look in Roblox.Platform.AssetPermissions.AssetPermissionsVerifier line 164 for a funny typo
            Log::error("There was an exception while calling canEdit() :{$e->getMessage()}");
            return false;
        }
    }

    public function tryCanPlay(User $user, Place $place) : bool
    {
        $success = false;
        $canPlay = false;
        try {
            $canPlay = $this->canPlay($user, $place);
            return true;
        } catch(Exception $e)
        {   
            // fun piece of trivia, look in Roblox.Platform.AssetPermissions.AssetPermissionsVerifier line 164 for a funny typo
            Log::error("There was an exception while calling canPlay() :{$e->getMessage()}");
            return false;
        }
    }

    /**
     * This is a different check from the {@see \GooberBlox\Platform\AssetPermissions\AssetPermissionsVerifier::isCopyLocked()} method.
     * The isCopyLocked() method checks if the place is able to be copied as a template to be created by a universe.
     * This method checks the AssetOption to see if it can be copied as a place to be created by a user.
     *
     * @param \GooberBlox\Platform\Assets\Place $place
     * @return bool
     */

    private function isCopyLocked(Place $place) : bool
    {
        return AssetOption::getOrCreate($place->asset->id)->is_copy_locked;
    }
}