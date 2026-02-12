<?php

namespace GooberBlox\Platform\Infrastructure;

use Illuminate\Support\Facades\Cache;

use GooberBlox\Platform\Infrastructure\Models\Server;
use GooberBlox\Platform\Infrastructure\Enums\ServerType;
use GooberBlox\Platform\Infrastructure\Exceptions\NoAvailableServerException;
class ServerManager
{
    // TODO: Implement matchmaking
    public static function getServer()
    {
        $server = Server::has('serverFarm')
            ->where(function ($query) {
                $query->where('server_type_id', ServerType::GameServer);
            })
            ->first();

        if (!$server) 
            throw new NoAvailableServerException("No available game servers found.");

        return $server;
    }

}
