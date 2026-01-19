<?php

namespace GooberBlox\GameInstances\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Cache;

use GooberBlox\Platform\Games\Models\MatchMakingContext;
class GameInstance extends Model
{
    use HasUuids;
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

    public static function getInstance(string $jobId)
    {
        return Cache::remember('game_instance:' . $jobId, 0, function () use ($jobId) {
            return GameInstance::find($jobId);
        });
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
