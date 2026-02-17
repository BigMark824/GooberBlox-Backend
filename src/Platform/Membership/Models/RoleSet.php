<?php

namespace GooberBlox\Platform\Membership\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use GooberBlox\Account\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class RoleSet extends Model
{
    use Cachable;
    protected $fillable = [
        'name',
        'rank'
    ];

    public function accounts()
    {
        return $this->belongsToMany(
            Account::class,
            'account_role_sets',
            'role_set_id',
            'account_id'
        )->withTimestamps();
    }

    protected const CACHE_KEY = 'rolesets_all';
    protected const CACHE_TTL = 604800; // 7 daysss
    protected static function allRoles()
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return self::all()->keyBy('id');
        });
    }
    public static function get(int $id)
    {
        return self::allRoles()->get($id);
    }

    public static function getByName(string $name)
    {
        return self::allRoles()->first(
            fn($r) => strcasecmp($r->name, $name) === 0
        );
    }

    public static function getAll()
    {
        return self::allRoles()->values();
    }
}
