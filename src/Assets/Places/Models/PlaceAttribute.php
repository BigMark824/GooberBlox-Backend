<?php

    namespace GooberBlox\Assets\Places;

    use Illuminate\Database\Eloquent\Model;
    use GeneaLabs\LaravelModelCaching\Traits\Cachable;

    use GooberBlox\Assets\Models\Asset;
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
            'is_filtering_enabled'
        ];

        public function place()
        {
            return $this->belongsTo(Asset::class, 'place_id');
        }
        public function placeType()
        {
            return $this->belongsTo(PlaceTypes::class, 'place_type_id');
        }
    }
