<?php

namespace GooberBlox\GameInstances;

use Illuminate\Support\Facades\Cache;

use GooberBlox\Infrastructure\Models\Server;
use GooberBlox\Infrastructure\Enums\ServerType;
use GooberBlox\Infrastructure\Exceptions\NoAvailableServerException;
class ServerManager
{
    // TODO: Implement matchmaking
    public static function getServer()
    {
        $server = Cache::remember('server', 60, function () {
            return Server::where('server_type', ServerType::Gameserver)
                        ->orWhere('server_type', ServerType::MixServer)
                ->first();
        });

        if (!$server) 
            throw new NoAvailableServerException("No available game servers found.");

        return $server;
    }

}
