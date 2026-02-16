<?php

namespace GooberBlox\Platform\GameInstances;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use GooberBlox\Platform\GameInstances\Jobs\StartInstance;
use GooberBlox\Platform\GameInstances\Models\GameInstance;
use GooberBlox\Platform\GameInstances\Exceptions\NoAvailablePortException;
use GooberBlox\Platform\Infrastructure\Models\Server;
use GooberBlox\Platform\Infrastructure\ServerManager;
use GooberBlox\Platform\Games\Models\MatchmakingContext;
use GooberBlox\Platform\Assets\Models\Asset;

class InstanceManager
{
    protected int $placeId;

    public function __construct(int $placeId)
    {
        $this->placeId = $placeId;
    }

    public function getInstance(): ?GameInstance
    {
        return GameInstance::where('place_id', $this->placeId)
            ->orderBy('created_at', 'asc')
            ->first();
    }

    public function getNextAvailablePort(Server $server): int
    {
        $minPort = 53640;
        $maxPort = 64000;

        $usedPorts = GameInstance::where('server_id', $server->id)
            ->whereNotNull('port')
            ->pluck('port')
            ->toArray();

        $attempts = 0;
        while ($attempts < 100) {
            $port = rand($minPort, $maxPort);
            if (!in_array($port, $usedPorts)) {
                return $port;
            }
            $attempts++;
        }

        throw new NoAvailablePortException("No available port found on server {$server->name}");
    }

    public function createInstance(?string $jobId, int $gamePort, string $gameCode, Server $server): GameInstance
    {
        $place = Asset::getPlace($this->placeId);

        $instance = new GameInstance();
        $instance->id = $jobId ?? Str::uuid();
        $instance->place_id = $place->id;
        $instance->capacity = $place->maxPlayers ?? 24;
        $instance->port = $gamePort;
        $instance->game_code = $gameCode;
        $instance->server_id = $server->id;
        $instance->matchmaking_context_id = MatchmakingContext::getOrCreate('Default')->id;
        $instance->save();

        return $instance;
    }
}
