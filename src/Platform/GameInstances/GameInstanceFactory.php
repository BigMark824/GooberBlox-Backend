<?php

namespace GooberBlox\Platform\GameInstances;

use GooberBlox\Platform\GameInstances\Data\PlaceSummary;
use GooberBlox\Platform\GameInstances\Models\GameInstance;

class GameInstanceFactory
{
    public function getGameInstance(int $placeId, string $gameInstanceId): ?GameInstance
    {
        return GameInstance::getGame($placeId, $gameInstanceId);
    }

    public function getGameInstancesByIds(int $placeId, array $gameInstanceIds): array
    {
        return GameInstance::where('place_id', $placeId)
            ->whereIn('id', $gameInstanceIds)
            ->get()
            ->all();
    }

    public function getPaged(int $placeId, int $startRowIndex, int $maximumRows): array
    {
        return GameInstance::where('place_id', $placeId)
            ->orderBy('created_at')
            ->skip($startRowIndex)
            ->take($maximumRows)
            ->get()
            ->all();
    }

    public function getGameInstances(int $placeId, bool $includePrivateInstances, ?array $gameCodes, ?int $matchmakingContextId, int $startRowIndex, int $maximumRows): array
    {
        $query = GameInstance::where('place_id', $placeId);

        if (!empty($gameCodes)) $query->whereIn('game_code', $gameCodes);

        if ($matchmakingContextId !== null) $query->where('matchmaking_context_id', $matchmakingContextId);

        return $query->orderBy('created_at')
                    ->skip($startRowIndex)
                    ->take($maximumRows)
                    ->get()
                    ->all();
    }

    public function getPlaceSummary(int $placeId): PlaceSummary
    {
        $query = GameInstance::where('place_id', $placeId);

        return new PlaceSummary(
            id: $placeId,
            gameCount: $query->count(),
            playerCount: $query->sum('player_count'),
        );
    }

    public function getPlayerCount(int $placeId): int
    {
        return $this->getPlaceSummary($placeId)->playerCount ?? 0;
    }
}
