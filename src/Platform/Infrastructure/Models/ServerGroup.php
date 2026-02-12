<?php

namespace GooberBlox\Platform\Infrastructure\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class ServerGroup extends Model
{
    use Cachable;
    protected $fillable = [
        'group_type_id',
        'name',
        'description'
    ];

    public function servers()
    {
        return $this->belongsToMany(
            Server::class,
            'server_group_members',
            'server_group',
            'server_id'
        );
    }

}
