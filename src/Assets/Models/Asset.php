<?php

namespace GooberBlox\Assets\Models;

use Illuminate\Database\Eloquent\Model;
use GooberBlox\Universes\Models\Universes;
use GooberBlox\Assets\Models\AssetHashes;
use GooberBlox\User\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

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

        static::updated(function ($assets) 
        {
            Cache::forget("asset_{$assets->id}");
        });
    }
    public function getAssetHash(int $assetId)
    {
        return Cache::remember("asset_hash_{$assetId}", 3600, function () use ($assetId) {
            $asset = $this->getAsset($assetId);
            return $asset?->assetHash?->hash;
        });
    }

    public function getAsset(int $assetId): Asset
    {
        $asset = Cache::remember("asset:{$assetId}", 3600, function () use ($assetId) {
            return Asset::find($assetId);
        });
        
        if(!$asset)
        {
            Cache::forget("asset:{$assetId}");
            throw new UnknownAssetException();
        }

        return $asset;
    }

    public static function getPlace(?int $placeId = null, int $ttl = 3600): Asset
    {
        return Cache::remember("asset:place:{$placeId}", $ttl, function () use ($placeId) {
            try {
                return Asset::where('id', $placeId)
                    ->where('asset_type_id', AssetType::Place)
                    ->with('universe')
                    ->firstOrFail();
            } catch (UnknownAssetException $e) {
                Cache::forget("asset:place:{$placeId}");
                throw $e;
            }
        });
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
