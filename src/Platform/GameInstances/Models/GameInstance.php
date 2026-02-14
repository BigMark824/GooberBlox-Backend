<?php

namespace GooberBlox\Platform\GameInstances\Models;

use GooberBlox\Assets\Models\Asset;
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
}
