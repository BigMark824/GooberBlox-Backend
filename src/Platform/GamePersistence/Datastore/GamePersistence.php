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

    // TODO: make a bit cleaner
    public function getSorted(int $placeId, $type, $scope, bool $ascending = false, $exclusiveStartKey, $pageSize, $inclusiveMinValue = null, $exclusiveMaxValue = null): array
    {
        if (!$placeId || !$type || !$scope) {
            return [];
        }
    
        $order = ($ascending == "True") ? 'asc' : 'desc';
    
        $query = DataStore::where('place_id', $placeId)
            ->where('type', $type)
            ->where('scope', $scope);
    
        if ($inclusiveMinValue !== NULL) {
            $query->where('value', '>=', $inclusiveMinValue);
        }
        if ($exclusiveMaxValue !== NULL) {
            $query->where('value', '<', $exclusiveMaxValue);
        }
    
        $query->orderBy('value', $order);
    
        $results = $query->paginate($pageSize, ['*'], 'page', $exclusiveStartKey);
    
        $datalist = [];
        foreach ($results as $data) {
            $datalist[] = [
                "Value" => $data->value,
                "Key" => $data->key,
                "Target" => $data->target,
                "Scope" => $data->scope
            ];
        }

        return [
            "Entries" => $datalist,
            "ExclusiveStartKey" => $results->hasMorePages() ? $results->currentPage() + 1 : null
        ];
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