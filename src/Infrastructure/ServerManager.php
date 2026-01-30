<?php

namespace GooberBlox\Infrastructure;

use Illuminate\Support\Facades\Cache;

use GooberBlox\Infrastructure\Models\Server;
use GooberBlox\Infrastructure\Enums\ServerType;
use GooberBlox\Infrastructure\Exceptions\NoAvailableServerException;
class ServerManager
{
    // TODO: Implement matchmaking
    public static function getServer()
    {
        $server = Server::has('serverFarm')
            ->where(function ($query) {
                $query->where('server_type_id', ServerType::Gameserver)
                    ->orWhere('server_type_id', ServerType::MixServer);
            })
            ->first();

        if (!$server) 
            throw new NoAvailableServerException("No available game servers found.");

        return $server;
    }

}
