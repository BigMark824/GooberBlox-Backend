<?php

namespace GooberBlox\Platform\Outfits;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

use GooberBlox\Platform\Outfits\KeyGeneratorInput;
class KeyGenerator
{
    // For more information see Roblox.Platform.Outfits.KeyGenerator
    public function generateKeyUrl(KeyGeneratorInput $generatorInput): string
        {
            $url = URL::to('/Asset/AvatarAccoutrements.ashx') . '?';

            if (!empty($generatorInput->avatarHash)) {
                $url .= 'AvatarHash=' . $generatorInput->avatarHash;
            } else {
                $url .= 'BodyColorSetID=' . $generatorInput->bodyColorSetID;
            }

            $assetIds = $generatorInput->assetIds;
            sort($assetIds, SORT_NUMERIC);

            $url .= '&AssetIDs=' . implode(',', $assetIds);

            if (!empty($generatorInput->equippedGearId) && $generatorInput->equippedGearId !== 0) {
                $url .= '&EquippedGearID=' . $generatorInput->equippedGearId;
            }

            return $url;
        }


    public function uploadSha1(string $keyUrl): string
    {
        // Friendly for non S3 users
        $bytes = mb_convert_encoding($keyUrl, 'UTF-8', 'UTF-8');
        $sha1 = sha1($bytes);

        $path = "avatar-hashes/{$sha1}";

        if (config('filesystems.disks.s3')) {
            $s3 = Storage::disk('s3');

            if (!$s3->exists($path)) {
                $s3->put($path, $sha1);
            }

            return $sha1;
        }

        $local = Storage::disk('local');

        if (!$local->exists($path)) {
            $local->put($path, $sha1);
        }

        return $sha1;
    }

}