<?php

namespace GooberBlox\Platform\Assets\Models;

use Illuminate\Database\Eloquent\Model;

class AssetOption extends Model
{
    protected $fillable = [
        'asset_id',
        'enable_comments',
        'enable_ratings',
        'is_copy_locked',
        'is_friends_only',
        'is_allowing_gear',
        'allowed_gear_categories',
        'default_expiration_in_ticks',
        'enforce_genre',
        'is_expirable'
    ];

    public function getOrCreate(int $assetId)
    {
        return self::firstOrCreate(
            ['asset_id' => $assetId],
            [
                'enable_comments' => false,
                'enable_ratings' => false,
                'is_copy_locked' => true,
                'is_friends_only' => false,
                'allowed_gear_categories' => 0,
                'default_expiration_in_ticks' => null,
                'enforce_genre' => false,
                'min_membership_type' => 0,
            ]
        );
    }
    public function getIsAllowingGearAttribute(): bool
    {
        return $this->allowed_gear_categories != 0;
    }

    public function getIsExpireableAttribute(): bool
    {
        return !is_null($this->default_expiration_in_ticks);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
