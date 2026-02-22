<?php

namespace GooberBlox\Platform\Assets\Models;


use GooberBlox\Agent\Enums\AgentType;
use GooberBlox\Agent\Models\Agent;
use GooberBlox\Platform\Groups\Models\Group;
use Illuminate\Database\Eloquent\Model;

use GooberBlox\Platform\Assets\Places\Models\PlaceAttribute;
use GooberBlox\Platform\Universes\Models\Universe;
use GooberBlox\Platform\Membership\Models\User;

use GooberBlox\Platform\Assets\Exceptions\UnknownAssetException;
use GooberBlox\Platform\Assets\Enums\AssetType;

use GooberBlox\Web\SEO\NameConverter;

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

    public static function getSEOUrl(Asset $asset) : string
    {
        if($asset == null)
        {
            return "";
        }

        (string)$name = NameConverter::convertToSEO($asset->name);

        if($asset->asset_type_id == AssetType::Place)
        {
            return "/games/{$asset->id}/{$name}";
        }

        return "/catalog/{$asset->id}/{$name}";
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
        return $this->belongsTo(AssetHash::class, 'asset_hash_id');
    }

    public function versions()
    {
        return $this->hasMany(AssetVersion::class);
    }

    public function currentVersion()
    {
        return $this->belongsTo(AssetVersion::class, 'current_version_id');
    }

    public function creatorAgent()
    {
        return $this->hasOne(Agent::class, 'agent_target_id', 'creator_id');
    }

    public function getCreatorAttribute()
    {
        return $this->creatorAgent?->target;
    }
    public function getCreatorTypeAttribute(): ?string
    {
        if (!$this->creatorAgent) return null;

        return match($this->creatorAgent->agent_type) {
            User::class => 'User',
            Group::class => 'Group',
            default => null,
        };
    }

    public function getCreatorTargetIdAttribute(): ?int
    {
        return $this->creatorAgent?->agent_target_id;
    }

}
