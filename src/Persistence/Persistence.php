<?php

namespace GooberBlox\Persistence;

use GooberBlox\Assets\Exceptions\UnknownAssetException;
use GooberBlox\Universes\Exceptions\UnknownUniverseException;
use GooberBlox\Persistence\Models\DataPersistence;
use GooberBlox\Assets\Models\Asset;

class Persistence {
    public static function getBlob(?int $agentId, ?int $placeId): ?DataPersistence
    {
        if ($agentId === null) {
            throw new \InvalidArgumentException('UserId not supplied.');
        }

        if ($placeId === null) {
            throw new \InvalidArgumentException('PlaceId not supplied.');
        }

        $place = Asset::getPlace($placeId);

        if(!$place)
            throw new UnknownAssetException($placeId);
        
        if(!$place->universe)
            throw new UnknownUniverseException();

        $blob = DataPersistence::where('universe_id', $place->universe->id)
                            ->where('agent_id', $agentId)
                            ->first();
        
        return $blob;
    }
    public static function setBlob(int $agentId, int $placeId, string $blob)
    {
        $place = Asset::getPlace($placeId);

        if(!$place)
            throw new UnknownAssetException($placeId);
        
        if(!$place->universe)
            throw new UnknownUniverseException();

        DataPersistence::updateOrCreate([
            'universe_id' => $place->universe->id,
            'agent_id' => $agentId
        ],
        [
            'blob' => gzdecode($blob)
        ]);
    }
}