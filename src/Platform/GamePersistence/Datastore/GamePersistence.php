<?php

namespace GooberBlox\Platform\GamePersistence\Datastore;

use GooberBlox\Platform\GamePersistence\Datastore\Jobs\SetAsync;
use GooberBlox\Platform\GamePersistence\Datastore\Models\Datastore;
use GooberBlox\Platform\GamePersistence\Datastore\Exceptions\UnknownDatastoreValueException;
use GooberBlox\Platform\Universes\Enums\DatastoreType;

class GamePersistence
{
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
    ){
        $this->placeId = $placeId;
        $this->key = $key;
        $this->type = $type;
        $this->scope = $scope;
        $this->target = $target;
        $this->value = $value;
        $this->datastoreType = $datastoreType;
    }
    public function get() : Datastore
    {
        $datastore = DataStore::where('place_id', $this->placeId)
            ->where('type', $this->type)
            ->where('scope', $this->scope)
            ->where('datastore_type', $this->datastoreType);

        if(!$datastore)
            throw new UnknownDatastoreValueException();

        return $datastore;
    }
    public function setAync() : void
    {
        $datastore = SetAsync::dispatch(
            $this->placeId,
            $this->key,
            $this->type,
            $this->scope,
            $this->target,
            $this->value,
            $this->datastoreType
        );
    }
}