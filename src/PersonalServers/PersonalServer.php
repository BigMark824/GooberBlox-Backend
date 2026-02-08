<?php

namespace GooberBlox\PersonalServers;

use GooberBlox\Assets\Models\AssetVersion;
use GooberBlox\PersonalServers\Exceptions\{InvalidPersonalServerRoleException, PersonalServerUpdateException, UnknownPersonalServerException};

use GooberBlox\Assets\Enums\AssetType;
use GooberBlox\Platform\Assets\Place;
use GooberBlox\Assets\Models\AssetHash;

use GooberBlox\PersonalServers\Models\PersonalServerRoleset;
use GooberBlox\PersonalServers\Enums\PersonalServerRoles;
class PersonalServer {
    public static function savePersonalServer(Place $place, string $contents): void
    {
        if( !$place || !$place->asset->is_build_server )
        {
            throw new UnknownPersonalServerException();
        }

        $assetHash = AssetHash::upload($contents, $place->asset->creator_id, AssetType::Place);

        try {
            // TODO: abstract this
            $newVersionNumber = $place->asset->currentVersion++;
            $assetVersion = AssetVersion::create([
                'asset_id' => $place->asset->id,
                'version_number' => $newVersionNumber
            ]);

            $place->asset->asset_hash_id = $assetHash->id;
            $place->asset->current_version_id = $assetVersion->id;
            $place->asset->updated_at = now();
            $place->asset->save();


        } catch(\Exception $e) {
            throw new PersonalServerUpdateException($e->getMessage());
        }
    }

    public static function setRolesetForUser(Place $place, ?int $userId, PersonalServerRoles $newRank) : ?PersonalServerRoleset
    {
        if( !$place || !$place->asset->is_build_server )
        {
            throw new UnknownPersonalServerException();
        }

        if (!in_array($newRank, [
            PersonalServerRoles::OWNER,
            PersonalServerRoles::ADMIN,
            PersonalServerRoles::MEMBER,
            PersonalServerRoles::BANNED,
            PersonalServerRoles::VISITOR,
        ], true)) {
            throw new InvalidPersonalServerRoleException("Invalid Rank");
        }

        if ($newRank === PersonalServerRoles::VISITOR) {
            PersonalServerRoleset::where('place_id', $place->asset->id)
                ->where('user_id', $userId)
                ->delete();

            return null;
        } else {
            $rank = PersonalServerRoleset::where('place_id', $place->asset->id)
                ->where('user_id', $userId)
                ->first();
            
            if ($rank) {
                $rank->rank = $newRank->value;
                $rank->save();
            } else {
                $rank = new PersonalServerRoleset;
                $rank->place_id = $place->asset->id;
                $rank->user_id = $userId;
                $rank->rank = $newRank->value;
                $rank->save();
            }
        }

        return $rank;
    }

    public static function getRolesetForUser(Place $place, int $userId): PersonalServerRoles
    {
        if ( !$place || !$place->asset->is_build_server ) {
            throw new UnknownPersonalServerException();
        }

        if ($userId == $place->asset->creator->id) {
            return PersonalServerRoles::OWNER;
        }

        $rank = PersonalServerRoleset::where('user_id', $userId)
            ->where('place_id', $place->asset->id)
            ->first();

        return $rank ? PersonalServerRoles::from($rank->rank) : PersonalServerRoles::VISITOR;
    }

}