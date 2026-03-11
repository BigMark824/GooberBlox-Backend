<?php

namespace GooberBlox\Platform\Games\Models;


use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class MatchmakingContext extends Model
{
    use Cachable;
    protected $fillable = [
        'value',
    ];
    public static function getOrCreate(string $value): self
    {
        return self::firstOrCreate(
            ['value' => $value],
        );
    }
}
