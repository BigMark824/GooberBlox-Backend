<?php

namespace GooberBlox\PersonalServers;

use DB;
use GooberBlox\PersonalServers\Enums\PersonalServerRoles;
use GooberBlox\PersonalServers\Exceptions\InvalidPersonalServerRoleException;
use GooberBlox\PersonalServers\Exceptions\PersonalServerUpdateException;
use GooberBlox\PersonalServers\Exceptions\UnknownPersonalServerException;
use GooberBlox\PersonalServers\Models\PersonalServerRoleset;
use GooberBlox\Platform\Assets\Enums\AssetType;
use GooberBlox\Platform\Assets\Enums\CreatorType;
use GooberBlox\Platform\Assets\Models\Asset;
use GooberBlox\Platform\Assets\Models\AssetHash;
use GooberBlox\Platform\Assets\Models\AssetVersion;
use GooberBlox\Platform\Assets\Place;

class PersonalServer
{
    public static function savePersonalServer(Place $place, string $contents): void
    {
        if (! $place || ! $place->asset->is_build_server) {
            throw new UnknownPersonalServerException;
        }

        try {
            $assetHash = AssetHash::upload(
                $contents,
                $place->asset->creator_id,
                AssetType::Place
            );

            DB::transaction(function () use ($place, $assetHash) {
                $asset = Asset::whereKey($place->asset->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $newVersionNumber = ((int) $asset->versions()->max('version_number')) + 1;

                $assetVersion = AssetVersion::create([
                    'asset_id' => $asset->id,
                    'version_number' => $newVersionNumber,
                    'asset_hash_id' => $assetHash->id,
                    'creator_type' => CreatorType::User,
                    'creator_target_id' => $asset->creator_id,
                    'creating_universe_id' => $asset->universe_id,
                ]);

                $asset->asset_hash_id = $assetHash->id;
                $asset->current_version_id = $assetVersion->id;
                $asset->updated_at = now();
                $asset->save();
            }, 3);
        } catch (\Throwable $e) {
            throw new PersonalServerUpdateException($e->getMessage(), 0, $e);
        }
    }

    public static function setRolesetForUser(Place $place, ?int $userId, PersonalServerRoles $newRank): ?PersonalServerRoleset
    {
        if (! $place || ! $place->asset->is_build_server) {
            throw new UnknownPersonalServerException;
        }

        if (! in_array($newRank, [
            PersonalServerRoles::OWNER,
            PersonalServerRoles::ADMIN,
            PersonalServerRoles::MEMBER,
            PersonalServerRoles::BANNED,
            PersonalServerRoles::VISITOR,
        ], true)) {
            throw new InvalidPersonalServerRoleException('Invalid Rank');
        }

        return DB::transaction(function () use ($place, $userId, $newRank) {
            if ($newRank === PersonalServerRoles::VISITOR) {
                PersonalServerRoleset::where('place_id', $place->asset->id)
                    ->where('user_id', $userId)
                    ->delete();

                return null;
            }

            $rank = PersonalServerRoleset::firstOrCreate(
                [
                    'place_id' => $place->asset->id,
                    'user_id' => $userId,
                ],
                [
                    'rank' => $newRank->value,
                ]
            );

            if ($rank->rank !== $newRank->value) {
                $rank->update([
                    'rank' => $newRank->value,
                ]);
            }

            return $rank;
        });
    }

    public static function getRolesetForUser(Place $place, int $userId): PersonalServerRoles
    {
        if (! $place || ! $place->asset->is_build_server) {
            throw new UnknownPersonalServerException;
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
