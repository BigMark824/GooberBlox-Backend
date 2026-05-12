<?php

namespace GooberBlox\Library\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class FeedType extends Model
{
    use Cachable;
    protected $fillable = [
        'type',
        'lifetime',
        'enabled'
    ];
    public static function getByType(string $type): ?self
    {
        return self::where('type', $type)->first();
    }

    public static function status(): ?self
    {
        return self::getByType('status');
    }

    public static function group(): ?self
    {
        return self::getByType('group');
    }

    public static function newPlace(): ?self
    {
        return self::getByType('newplace');
    }

    public static function boughtItem(): ?self
    {
        return self::getByType('boughtitem');
    }

    public static function place(): ?self
    {
        return self::getByType('place');
    }

    public static function character(): ?self
    {
        return self::getByType('character');
    }

    public static function playGame(): ?self
    {
        return self::getByType('playgame');
    }

    public static function getLifetime(): ?self
    {
        return self::status()?->lifetime ?? 0;
    }
}
