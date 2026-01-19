<?php

namespace GooberBlox\Assets\Places\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

use GooberBlox\Assets\Models\Asset;
use GooberBlox\Assets\Exceptions\UnknownAssetException;
class PlaceAttribute extends Model
{
    use Cachable;

    protected $originalUniverseID;

    protected $originalUniverseIDIsDirty = false;

    protected $fillable = [
        'place_id',
        'place_type_id',
        'use_place_media_for_thumb',
        'overrides_default_avatar',
        'use_portrait_mode',
        'universe_id',
        'is_filtering_enabled',
    ];

    public static function getOrCreate(array $attributes): self
    {
        if (!isset($attributes['place_id'])) {
            throw new UnknownAssetException();
        }

        return self::firstOrCreate(
            ['place_id' => $attributes['place_id']],
            [
                'universe_id' => Asset::find($attributes['place_id'])->universe_id ?? null,
                'place_type_id' => $attributes['place_type_id'] ?? null,
                'use_place_media_for_thumb' => $attributes['use_place_media_for_thumb'] ?? false,
                'overrides_default_avatar' => $attributes['overrides_default_avatar'] ?? false,
                'use_portrait_mode' => $attributes['use_portrait_mode'] ?? false,
                'is_filtering_enabled' => $attributes['is_filtering_enabled'] ?? false,
            ]
        );
    }

    public function place()
    {
        return $this->belongsTo(Asset::class, 'place_id');
    }

    public function placeType()
    {
        return $this->belongsTo(PlaceTypes::class, 'place_type_id');
    }
}
