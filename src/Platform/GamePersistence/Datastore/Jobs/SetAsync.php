<?php

namespace GooberBlox\Platform\GamePersistence\Datastore\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use GooberBlox\Platform\Universes\Enums\DatastoreType;
use GooberBlox\Platform\GamePersistence\Datastore\Models\Datastore;
use GooberBlox\Platform\GamePersistence\Datastore\Events\DatastoreEvent;
class SetAsync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected int $placeId;
    protected string $key;
    protected string $type;
    protected string $scope;
    protected string $target;
    protected string $value;
    protected DatastoreType $datastoreType;

    public function __construct(
        int $placeId,
        string $key,
        string $type, 
        string $scope, 
        string $target, 
        string $value,
        DatastoreType $datastoreType
    ) {
        $this->placeId = $placeId;
        $this->key = $key;
        $this->type = $type;
        $this->scope = $scope;
        $this->target = $target;
        $this->value = $value;
        $this->datastoreType = $datastoreType;
    }

    public function handle() : void
    {
        Datastore::updateOrCreate(
            [
                'universe_id' => $this->placeId,
                'key' => $this->key,
                'scope' => $this->scope,
                'target' => $this->target,
            ],
            [
                'type' => $this->type,
                'value' => $this->value,
                'datastore_type' => $this->datastoreType,
            ]
        );

        event(new DatastoreEvent(
            $this->job->uuid(),
            $this->placeId,
            $this->key,
            $this->type,
            $this->scope,
            $this->target,
            $this->value,
            $this->datastoreType
        ));
    }
}
