<?php

namespace GooberBlox\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $fillable = [
        'name',
        'host_name',
        'server_farm_id',
        'server_type_id',
        'datacenter_id',
        'private_ip_address',
        'primary_ip_address'
    ];

    public function serverFarm()
    {
        return $this->belongsTo(ServerFarm::class);
    }
}
