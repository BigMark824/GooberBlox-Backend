<?php
namespace GooberBlox\Platform\GamePersistence\Datastore\Events;

use GooberBlox\Platform\Universes\Enums\DatastoreType;

class DatastoreEvent
{
    public function __construct(
        public string $jobId,
        public int $placeId,
        string $key,
        string $type, 
        string $scope, 
        string $target, 
        string $value,
        DatastoreType $datastoreType
    ) {}
}
