<?php

namespace GooberBlox\Platform\GameInstances;

use GooberBlox\Platform\GameInstances\Models\GameInstance;
use Illuminate\Support\Facades\Cache;

class GameInstanceFactory
{
    public function getGameInstance(int $placeId, string $gameInstanceId): ?GameInstance
    {
        $key = "game_instances:get_game_instance:place_id:{$placeId}:game_instance_id:{$gameInstanceId}";

        return Cache::remember($key, 3600, function () use ($placeId, $gameInstanceId) {
            return GameInstance::getGame($placeId, $gameInstanceId);
        });
    }

    public function getGameInstancesByIds(int $placeId, array $gameInstanceIds): array
    {
        sort($gameInstanceIds);
        $instanceIds = implode('|', $gameInstanceIds);
        $hash = hash('sha256', $instanceIds);

        $key = "game_instances:get_game_instances_by_ids:place_id:{$placeId}:hash:{$hash}";

        return Cache::remember($key, 3600, function () use ($placeId, $gameInstanceIds) {
            return GameInstance::where('place_id', $placeId)
                ->whereIn('id', $gameInstanceIds)
                ->get()
                ->all();
        });
    }

    public function getPaged(int $placeId, int $startRowIndex, int $maximumRows): array
    {
        $key = "game_instances:get_paged:place_id:{$placeId}:start_row_index:{$startRowIndex}:maximum_rows:{$maximumRows}";

        return Cache::remember($key, 3600, function () use ($placeId, $startRowIndex, $maximumRows) {
            return GameInstance::where('place_id', $placeId)
                ->orderBy('created_at') 
                ->skip($startRowIndex)
                ->take($maximumRows)
                ->get()
                ->all();
        });
    }

    public function getGameInstances(int $placeId, bool $includePrivateInstances, ?array $gameCodes, ?int $matchmakingContextId, int $startRowIndex, int $maximumRows): array
    {
        $gameCodesString = ($gameCodes !== null && count($gameCodes) > 0) ? implode('|', sort($gameCodes) ?: $gameCodes) : 'null';
        $matchmakingContextString = $matchmakingContextId !== null ? (string) $matchmakingContextId : 'null';

        $key = "game_instances:get_game_instances:place_id:{$placeId}:include_private_instances:{$includePrivateInstances}:game_codes:{$gameCodesString}:matchmaking_context_id:{$matchmakingContextString}:start_row_index:{$startRowIndex}:maximum_rows:{$maximumRows}";

        return Cache::remember($key, 3600, function () use ($placeId, $gameCodes, $matchmakingContextId, $startRowIndex, $maximumRows) {
            $query = GameInstance::where('place_id', $placeId);

            if (!empty($gameCodes)) $query->whereIn('game_code', $gameCodes);

            if ($matchmakingContextId !== null) $query->where('matchmaking_context_id', $matchmakingContextId);

            return $query->orderBy('created_at')
                        ->skip($startRowIndex)
                        ->take($maximumRows)
                        ->get()
                        ->all();
        });
    }
}