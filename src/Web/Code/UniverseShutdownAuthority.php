<?php

use GooberBlox\Platform\Assets\Place;
use GooberBlox\Platform\GameInstances\Models\GameInstance;
use GooberBlox\Platform\Games\Models\MatchmakingContext;
use GooberBlox\Platform\Games\GamesAuthority;
use GooberBlox\Platform\Membership\Models\User;
class UniverseShutdownAuthority {
    private GameInstance $gameInstance;
    private Place $place;
    private MatchmakingContext $matchmakingContext;
    private GamesAuthority $gamesAuthority;

    public function __construct(GameInstance $gameInstance, Place $place, MatchmakingContext $matchmakingContext, GamesAuthority $gamesAuthority)
    {
        $this->gameInstance = $gameInstance ?? throw new InvalidArgumentException("gameInstance");
        $this->place = $place ?? throw new InvalidArgumentException("place");
        $this->matchmakingContext = $matchmakingContext ?? throw new InvalidArgumentException("matchmakingContext");
        $this->gamesAuthority = $gamesAuthority ?? throw new InvalidArgumentException("gamesAuthority");
    }

    public function closeAllGameInstances(int $universeId, User $authenticatedUser): bool
    {
        $checkedPlaceIds = [];
        $doneCount = 0;
        try {
            $cloudEditMatchmakingContext = $this->matchmakingContext->getOrCreate('CloudEdit')->id;

            do 
            {
                $instances = GameInstance::whereRelation('asset', 'universe_id', $universeId)->get();   
                
                foreach($instances as $instance)
                {
                    if (!isset($checkedPlaceIds[$instance->place_id])) {
                        $place = new Place($instance->place_id);
                        if(!$authenticatedUser->canShutdownGameInstance($authenticatedUser, $place /*, AssetPermissionVerifier $assetPermissionsVerifier */))
                        {
                            throw new \Exception("Failure to shut down one of the places for a universe.  placeId={$place->id} universeId={$universeId}");
                        }
                    }

                    $checkedPlaceIds[$instance->place_id] = true;

                    $this->gamesAuthority->close($instance->place_id, $instance->id, 1, $cloudEditMatchmakingContext);
                }

                $doneCount += 1000;
            } while($instances->count() == 1000);
        } catch(\Exception $e) {
            throw new \Exception("Caught an exception trying to shut down all game instances for universe Id = {$universeId}. \nThe exception was {$e->getMessage()} with the following stack trace : {$e->getTraceAsString()}");
        }

        return true;
    }
}