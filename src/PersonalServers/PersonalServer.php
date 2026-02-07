<?php

namespace GooberBlox\PersonalServers;

use GooberBlox\Assets\Models\AssetVersion;
use GooberBlox\PersonalServers\Exceptions\{InvalidPersonalServerRoleException, PersonalServerUpdateException, UnknownPersonalServerException};

use GooberBlox\Assets\Enums\AssetType;
use GooberBlox\Platform\Assets\Place;
use GooberBlox\Assets\Models\AssetHash;

use GooberBlox\PersonalServers\Models\PersonalServerRanks;
use GooberBlox\PersonalServers\Enums\PersonalServerRoleset;
class PersonalServer {
    public static function savePersonalServer(Place $place, string $contents): void
    {
        if( !$place || !$place->asset->isBuildServer )
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

    public static function setRolesetForUser(Place $place, ?int $userId, PersonalServerRoleset $newRank) : ?PersonalServerRanks
    {
        if( !$place || !$place->asset->isBuildServer )
        {
            throw new UnknownPersonalServerException();
        }

        if (!in_array($newRank, [
            PersonalServerRoleset::OWNER,
            PersonalServerRoleset::ADMIN,
            PersonalServerRoleset::MEMBER,
            PersonalServerRoleset::BANNED,
            PersonalServerRoleset::VISITOR,
        ], true)) {
            throw new InvalidPersonalServerRoleException("Invalid Rank");
        }

        if ($newRank === PersonalServerRoleset::VISITOR) {
            PersonalServerRanks::where('place_id', $place->asset->id)
                ->where('user_id', $userId)
                ->delete();

            return null;
        } else {
            $rank = PersonalServerRanks::where('place_id', $place->asset->id)
                ->where('user_id', $userId)
                ->first();
            
            if ($rank) {
                $rank->rank = $newRank->value;
                $rank->save();
            } else {
                $rank = new PersonalServerRanks;
                $rank->placeId = $place->asset->id;
                $rank->userId = $userId;
                $rank->rank = $newRank->value;
                $rank->save();
            }
        }

        return $rank;
    }

    public static function getRolesetForUser(Place $place, int $userId): PersonalServerRoleset
    {
        if ( !$place || !$place->asset->isBuildServer ) {
            throw new UnknownPersonalServerException();
        }

        if ($userId == $place->asset->creator->id) {
            return PersonalServerRoleset::OWNER;
        }

        $rank = PersonalServerRanks::where('user_id', $userId)
            ->where('place_id', $place->asset->id)
            ->first();

        return $rank ? PersonalServerRoleset::from($rank->rank) : PersonalServerRoleset::VISITOR;
    }

}