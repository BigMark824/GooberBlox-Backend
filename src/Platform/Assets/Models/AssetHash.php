<?php

namespace GooberBlox\Platform\Assets\Models;

use GooberBlox\Platform\Assets\Enums\AssetType;
use GooberBlox\Platform\Assets\Enums\CreatorType;
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

        return AssetHash::create([
            'asset_type_id' => $assetType,
            'hash' => $hash,
            'creator_id' => $creatorId,
            'creator_type' => $creatorType
        ]);
    }
    public static function retrieve(string $hash): string
    {
        return FilesManager::singleton()->getStream($hash);
    }

}
