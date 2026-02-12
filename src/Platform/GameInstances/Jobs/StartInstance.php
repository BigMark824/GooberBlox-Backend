<?php

namespace GooberBlox\Platform\GameInstances\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Virtubrick\Grid\GridService;
use Virtubrick\Grid\Rcc\{Job, LuaScript};
use GooberBlox\Platform\Infrastructure\Models\Server;
use GooberBlox\Platform\GameInstances\InstanceManager;

class StartInstance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $serverId;
    protected int $placeId;
    protected int $universeId;
    protected string $serverIp;
    protected int $maxPlayers;
    protected bool $isBuildServer;
    protected bool $isCloudEdit;
    protected int $gamePort;

    public function __construct(
        int $serverId,
        int $placeId,
        int $maxPlayers,
        bool $isBuildServer,
        bool $isCloudEdit,
        int $gamePort,
        ?int $universeId = null,
        ?string $serverIp = null
    ) {
        $this->serverId = $serverId;
        $this->placeId = $placeId;
        $this->maxPlayers = $maxPlayers;
        $this->isBuildServer = $isBuildServer;
        $this->isCloudEdit = $isCloudEdit;
        $this->gamePort = $gamePort;
        $this->universeId = $universeId ?? 0;
        $this->serverIp = $serverIp ?? '127.0.0.1';
    }

    public function handle(): void
    {
        $job = new Job('', $expirationInSeconds = 9000000);

        try {
            $gridService = new GridService("http://{$this->serverIp}:" . config('grid.Defaults.Port'));

            $luaScript = new LuaScript(
                "GameServer",
                sprintf('loadfile("%s")(...)', url('/game/gameserver.ashx', [], false)),
                [
                    $this->placeId,
                    $this->gamePort,
                    $job->id,
                    0,
                    env('GRID_ACCESS_KEY'),
                    'false',
                    35,
                    $this->serverIp,
                    1,
                    env('APP_MINIURL'),
                    $this->maxPlayers,
                    config('settings.PlaceSettings.maxGameInstances'),
                    $this->isBuildServer ? 124885177 : 0,
                    env('GRID_API_KEY'),
                    $this->isBuildServer ? 124885177 : 0,
                    0,
                    $job->id,
                    $this->universeId,
                    24,
                    $this->isCloudEdit ? 3 : 0,
                    env('PLACE_VISIT_KEY'),
                    'assetgame',
                    'http://',
                    false
                ]
            );

            $job->arbiter($gridService)->script($luaScript)->open();
            
            $instanceManager = new InstanceManager($this->placeId);
            $server = Server::find($this->serverId);

            $instanceManager->createInstance($job->id, $this->gamePort, $job->id, $server);

            Cache::forget("place:{$this->placeId}:starting");

            Log::info("StartInstance job completed", ['jobId' => $job->id]);
        } catch (\Exception $e) {
            Log::error("Failed to start instance", [
                'serverId' => $this->serverId,
                'placeId' => $this->placeId,
                'error' => $e->getMessage()
            ]);
        }
    }
}
