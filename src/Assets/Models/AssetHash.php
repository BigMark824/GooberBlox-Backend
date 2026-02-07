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

    public function versions()
    {
        return $this->hasMany(AssetVersion::class, 'asset_hash_id');
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

        $assetVersion = AssetVersion::create([
            'asset_id'
        ]);

        return $assetHash;
    }
    public static function retrieve(string $hash): string
    {
        return FilesManager::singleton()->getStream($hash);
    }

}
