<?php

namespace GooberBlox\Outfits\Models;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class BodyColorSet extends Model
{
    use Cachable;
    protected $fillable = [
        'head_color_id',
        'left_arm_color_id',
        'left_leg_color_id',
        'right_arm_color_id',
        'right_leg_color_id',
        'torso_color_id',
        'body_color_set_hash',
    ];

    public static function getByHash(string $hash)
    {
        if($hash.isEmptyOrNullString())
        {
            return null;
        }

        return self::where('body_color_set_hash', $hash)->first();
    }
}
