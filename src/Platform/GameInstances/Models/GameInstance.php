<?php

namespace GooberBlox\Platform\GameInstances\Models;

use GooberBlox\Platform\Assets\Models\Asset;
use GooberBlox\Platform\GameInstances\Exceptions\NoAvailablePortException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;

use GooberBlox\Platform\Games\Models\MatchMakingContext;
use GooberBlox\Platform\Infrastructure\Models\Server;
class GameInstance extends Model
{
    use HasUuids, Cachable;
    protected $fillable = [ 
        'place_id',
        'fps',
        'port',
        'ping',
        'player_ids',
        'capacity',
        'game_code',
        'server_id',
        'matchmaking_context_id',
    ];
    protected $casts = [
        'player_ids' => 'array',
    ];
    public function place()
    {
        return $this->belongsTo(Asset::class, 'place_id');
    }

    public static function getInstance(string $jobId)
    { 
        return GameInstance::find($jobId);
    }
    public function server()
    {
        return $this->belongsTo(Server::class, 'server_id');
    }
    public function matchmakingContext()
    {
        return $this->belongsTo(MatchmakingContext::class, 'matchmaking_context_id');
    }

    public static function getGame(int $placeId, string $gameInstanceId): ?GameInstance
    {
        return self::where('place_id', $placeId)
                    ->where('id', $gameInstanceId)
                    ->first();
    }

    public function getNextAvailablePort(Server $server): int
    {
        $minPort = 53640;
        $maxPort = 64000;

        $usedPorts = $this->where('server_id', $server->id)
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
}
