<?php

namespace GooberBlox\Assets\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

use GooberBlox\Assets\Places\Models\PlaceAttribute;
use GooberBlox\Universes\Models\Universes;
use GooberBlox\Assets\Models\AssetHashes;
use GooberBlox\Membership\Models\User;

use GooberBlox\Assets\Exceptions\UnknownAssetException;
use GooberBlox\Assets\Enums\AssetType;
class Asset extends Model
{
    protected $fillable = [
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

    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($assets) 
        {
            $assetHash = AssetHashes::create([
                'target_id' => $assets->id,
                'hash' => Str::uuid()
            ]);
        });
    }
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

    public static function getPlace(?int $placeId = null): Asset
    {
            try {
                return Asset::where('id', $placeId)
                    ->where('asset_type_id', AssetType::Place)
                    ->with('universe')
                    ->firstOrFail();
            } catch (UnknownAssetException $e) {
                throw $e;
            }
    }
    public function placeAttribute()
    {
        return $this->belongsTo(PlaceAttribute::class, 'place_id');
    }
    public function universe()
    {
        return $this->belongsTo(Universes::class, 'universe_id');
    }
    public function assetHash()
    {
        return $this->belongsTo(AssetHashes::class, 'asset_hash_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
