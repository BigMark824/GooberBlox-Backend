<?php

namespace GooberBlox\Platform\Games;

use GooberBlox\Platform\AssetPermissions\AssetPermissionsVerifier;
use GooberBlox\Platform\Assets\Place;
use GooberBlox\Platform\Membership\Models\User;

class UserExtensions {
    public static function canShutdownGameInstances(User $user, Place $place, AssetPermissionsVerifier $assetPermissionsVerifier) : bool
    {
        if(!$user)
            return false;

        if($user->isModerator())
            return true;

        return $assetPermissionsVerifier->canManage($user, $place->asset);
    }
}