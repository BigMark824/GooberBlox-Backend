<?php

namespace GooberBlox\GameInstances;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use GooberBlox\GameInstances\Jobs\StartInstance;
use GooberBlox\GameInstances\Models\GameInstance;
use GooberBlox\GameInstances\Exceptions\NoAvailablePortException;
use GooberBlox\Infrastructure\Models\Server;
use GooberBlox\Infrastructure\ServerManager;
use GooberBlox\Platform\Games\Models\MatchmakingContext;
use GooberBlox\Assets\Models\Asset;

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

    public function requestInstance(): void
    {
        if ($this->getInstance()) {
            return;
        }

        $place = Asset::getPlace($this->placeId);
        if (!$place) {
            Log::channel('instance_manager')->error("Place not found {$this->placeId}");
            return;
        }

        $server = ServerManager::getServer();
        if (!$server) {
            Log::channel('instance_manager')->error("No available server found for place {$this->placeId}");
            return;
        }

        $gamePort = $this->getNextAvailablePort($server);

        StartInstance::dispatch(
            serverId: $server->id,
            placeId: $place->id,
            maxPlayers: $place->maxPlayers ?? 24,
            isBuildServer: $place->is_build_server,
            isCloudEdit: false, // TODO: add
            gamePort: $gamePort,
            universeId: $place->universe->id ?? null,
            serverIp: $server->primary_ip_address
        );

        Log::channel('instance_manager')->info("Dispatched StartInstance job", [
            'serverId' => $server->id,
            'serverIp' => $server->primary_ip_address,
            'placeId' => $place->id,
            'isBuildServer' => $place->is_build_server,
            'universeId' => $place->universe->id ?? null,
            'gamePort' => $gamePort
        ]);
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
