<?php

namespace GooberBlox\Platform\Games\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;
class MatchmakingContext extends Model
{
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
