<?php

namespace GooberBlox\Assets\Models;

use GooberBlox\Assets\Enums\AssetType;
use GooberBlox\Assets\Enums\CreatorType;
use Illuminate\Database\Eloquent\Model;

use GooberBlox\Services\FilesManager;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class AssetHash extends Model
{
    use Cachable;
    protected $fillable = [
        'asset_type_id',
        'hash',
        'is_approved',
        'is_reviewed',
        'creator_id',
        'creator_type'
    ];
    public function asset()
    {
        return $this->hasOne(Asset::class);
    }

    public static function upload(string $contents, int $creatorId, AssetType $assetType, ?CreatorType $creatorType = CreatorType::User) : AssetHash
    {
        $hash = FilesManager::singleton()->addFile($contents);

        $assetHash = AssetHash::create([
            'asset_type_id' => $assetType,
            'hash' => $hash,
            'creator_id' => $creatorId,
            'creator_type' => $creatorType
        ]);

        return $assetHash;
    }
    public static function retrieve($hash): string
    {
        return FilesManager::singleton()->getStream($hash);
    }

}
