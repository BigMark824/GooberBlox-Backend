<?php

namespace GooberBlox\Library\PremiumFeatures\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class DurationType extends Model
{
    public const NONE_VALUE = 'None';
    public const ONE_MONTH_VALUE = '1 Month';
    public const FORTY_FIVE_DAYS_VALUE = '45 Days';
    public const SIX_MONTHS_VALUE = '6 Months';
    public const TWELVE_MONTHS_VALUE = '12 Months';
    public const LIFETIME_VALUE = 'Lifetime';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'value',
        'amount'
    ];

    protected static function booted()
    {
        static::saved(function ($model) {
            Cache::forget("duration_type:id:$model->id");
            Cache::forget("duration_type:value:$model->value");
        });

        static::deleted(function ($model) {
            Cache::forget("duration_type:id:$model->id");
            Cache::forget("duration_type:value:$model->value");
        });
    }
    public function getAmountTimeSpanAttribute() : CarbonInterval
    {
        return CarbonInterval::microseconds($this->amount / 10);
    }

    public static function getById(int $id): ?self
    {
        Cache::rememberForever("duration_type:id:{$id}", function() use ($id)
        {
            return self::find($id);
        });
    }

    public static function getByValue(string $value): ?self
    {
        return Cache::rememberForever("duration_type:value:$value", function () use ($value) {
            return self::where('value', $value)->first();
        });
    }

    public static function noneId(): ?int { return optional(self::getByValue(self::NONE_VALUE))->id; }
    public static function oneMonthId(): ?int { return optional(self::getByValue(self::ONE_MONTH_VALUE))->id; }
    public static function sixMonthsId(): ?int { return optional(self::getByValue(self::SIX_MONTHS_VALUE))->id; }
    public static function twelveMonthsId(): ?int { return optional(self::getByValue(self::TWELVE_MONTHS_VALUE))->id; }
    public static function lifetimeId(): ?int { return optional(self::getByValue(self::LIFETIME_VALUE))->id; }
    public static function fortyFiveDaysId(): ?int { return optional(self::getByValue(self::FORTY_FIVE_DAYS_VALUE))->id; }
}
