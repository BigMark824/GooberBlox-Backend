<?php

namespace GooberBlox\Platform\Infrastructure\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use GooberBlox\Platform\Infrastructure\Enums\ServerGroup as ServerGroupEnum;
class Server extends Model
{
    use Cachable;
    protected $fillable = [
        'name',
        'host_name',
        'server_farm_id',
        'server_type_id',
        'datacenter_id',
        'private_ip_address',
        'primary_ip_address'
    ];
    public function groups()
    {
        return $this->belongsToMany(
            ServerGroup::class,
            'server_group_members',
            'server_id',
            'server_group'
        );
    }

    public function serverFarm()
    {
        return $this->belongsTo(ServerFarm::class);
    }

    public function isBleedOff(): bool
    {
        $bleedOffGroups = [
            ServerGroupEnum::BleedOffNoNewGames->value,
            ServerGroupEnum::BleedOffNoMatchMaking->value,
        ];

        $groups = $this->groups ?? collect();

        return $groups->pluck('group_type')->intersect($bleedOffGroups)->isNotEmpty();
    }

}
