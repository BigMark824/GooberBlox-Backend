<?php
namespace GooberBlox\Platform\Games;

use GooberBlox\Platform\GameInstances\Models\GameInstance;
use GooberBlox\Platform\Games\Models\MatchmakingContext;

use Virtubrick\Grid\GridService;
use Virtubrick\Grid\Rcc\Job;
// This class is inaccurate as Roblox.Games.Client is NOT public.
class GamesAuthority {
    public function close(int $placeId, string $gameId, int $closeGameReasonType, MatchmakingContext $matchmakingContext): void
    {
        try {
            $gameInstance = GameInstance::where('place_id', $placeId)
                                    ->where('id', $gameId)
                                    ->where('matchmaking_context_id', $matchmakingContext->id)
                                    ->first();

            $job = new Job($gameId);
            $gridService = new GridService("http://{$gameInstance->server->primary_ip_address}:" . config('grid.Defaults.Port'));
            
            $job->arbiter($gridService);
            $job->closeJob();

            $gameInstance->delete();
        } catch(\Exception $e)
        {
            throw new \Exception("Failed to close server job at PlaceId: {$placeId}\n GameId: $gameId\n CloseGameReason: {$closeGameReasonType}");
        }

    }
}