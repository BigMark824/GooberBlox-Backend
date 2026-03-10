<?php

namespace GooberBlox\Economy\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use InvalidArgumentException;
class TicketsBalance extends Model
{
    Use Cachable;
    protected $fillable = [
        'user_id',
        'value'
    ];

    public static function getOrCreate(int $userId): self
    {
        return self::firstOrCreate(
            ['user_id' => $userId],
            ['value' => 0]
        );
    }

    public function credit(int $amount): void
    {
        if ($amount < 1) {
            throw new InvalidArgumentException('Required value not specified: Amount.');
        }

        DB::transaction(function () use ($amount) {
            $balance = RobuxBalance::whereKey($this->id)
                ->lockForUpdate()
                ->firstOrFail();

            $balance->value += $amount;
            $balance->updated_at = now();
            $balance->save();

            $this->value = $balance->value;
            $this->updated_at = $balance->updated_at;
        });
    }

    public function tryDebit(int $amount): bool
    {
        // Harley; we are not using eloquent here as raw SQL is faster at scale for high amounts of transactions
        $updated = DB::table($this->getTable())
            ->where('id', $this->id)
            ->where('value', '>=', $amount)
            ->update([
                'value' => DB::raw('value - ' . (int) $amount),
            ]);

        if ($updated > 0) {
            $this->refresh();
            return true;
        }

        return false;
    }
}
