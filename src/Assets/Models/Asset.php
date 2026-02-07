<?php

namespace GooberBlox\Assets\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use GooberBlox\Assets\Places\Models\PlaceAttribute;
use GooberBlox\Platform\Universes\Models\Universe;
use GooberBlox\Platform\Membership\Models\User;

use GooberBlox\Assets\Exceptions\UnknownAssetException;
use GooberBlox\Assets\Enums\AssetType;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class Asset extends Model
{
    use Cachable;
    protected $fillable = [
        'id',
        'asset_type_id',
        'asset_hash_id',
        'asset_categories',
        'asset_genres',
        'name',
        'creator_id',
        'current_version_id',
        'universe_id',
        'description',
        'is_archived'
    ];

    public function getAssetHash(int $assetId)
    {
        $asset = $this->getAsset($assetId);
        return $asset?->assetHash?->hash;
    }

    public function getAsset(int $assetId): Asset
    {
        $asset = Asset::find($assetId);
        
        if(!$asset)
        {
            throw new UnknownAssetException();
        }

        return $asset;
    }

    public static function getPlace(?int $placeId = null): ?Asset
    {
            try {
                return Asset::where('id', $placeId)
                    ->where('asset_type_id', AssetType::Place)
                    ->with('universe')
                    ->with('placeAttribute.placeType')
                    ->first();
            } catch (UnknownAssetException $e) {
                throw $e;
            }
    }
    public function placeAttribute()
    {
        return $this->hasOne(PlaceAttribute::class, 'place_id', 'id');
    }
    public function getIsBuildServerAttribute(): bool
    {
        return $this->placeAttribute?->placeType?->place_type === 'Personal Server';
    }


    public function universe()
    {
        return $this->belongsTo(Universe::class, 'universe_id');
    }
    public function assetHash()
    {
        return $this->hasOneThrough(
            AssetHash::class,
            AssetVersion::class,
            'id',
            'id',
            'current_version_id',
            'asset_hash_id'
        );
    }
    public function versions()
    {
        return $this->hasMany(AssetVersion::class);
    }

    public function currentVersion()
    {
        return $this->belongsTo(AssetVersion::class, 'current_version_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
