<?php

namespace GooberBlox\Platform\GamePersistence\Datastore;
use GooberBlox\Platform\GamePersistence\Datastore\Jobs\SetAsync;
use GooberBlox\Platform\GamePersistence\Datastore\Models\Datastore;
use GooberBlox\Platform\GamePersistence\Datastore\Exceptions\UnknownDatastoreValueException;
use GooberBlox\Platform\Universes\Enums\DatastoreType;

class GamePersistence
{
    protected int $universeId;
    protected ?string $key;
    protected string $type;
    protected string $scope;
    protected ?string $target;
    protected DatastoreType $datastoreType;

    public function __construct(
        int $universeId,
        ?string $key,
        string $type,
        string $scope,
        ?string $target,
        DatastoreType $datastoreType
    ) {
        $this->universeId = $universeId;
        $this->key = $key;
        $this->type = $type;
        $this->scope = $scope;
        $this->target = $target;
        $this->datastoreType = $datastoreType;
    }

    public function get()
    {
        $query = Datastore::where('universe_id', $this->universeId)
            ->where('type', $this->type)
            ->where('scope', $this->scope)
            ->where('datastore_type', $this->datastoreType);

        if ($this->target !== null && $this->key !== null) {
            $query->where('target', $this->target)
                ->where('key', $this->key);
        }

        return $query->get(); 
    }

    public function getSorted(
        string $type,
        string $scope,
        bool $ascending = false,
        ?int $exclusiveStartKey = null,
        int $pageSize = 50,
        $inclusiveMinValue = null,
        $exclusiveMaxValue = null
    ): array {
        $order = $ascending ? 'asc' : 'desc';

        $query = Datastore::where('universe_id', $this->universeId)
            ->where('type', $type)
            ->where('scope', $scope);

        if ($inclusiveMinValue !== null) {
            $query->where('value', '>=', $inclusiveMinValue);
        }

        if ($exclusiveMaxValue !== null) {
            $query->where('value', '<', $exclusiveMaxValue);
        }

        $query->orderBy('value', $order);

        $results = $query->paginate($pageSize, ['*'], 'page', $exclusiveStartKey ?? 1);

        $entries = [];
        foreach ($results as $data) {
            $entries[] = [
                'Value' => $data->value,
                'Key' => $data->key,
                'Target' => $data->target,
                'Scope' => $data->scope,
            ];
        }

        return [
            'Entries' => $entries,
            'ExclusiveStartKey' => $results->hasMorePages()
                ? $results->currentPage() + 1
                : null,
        ];
    }

    public function setAsync(string $value): void
    {
        SetAsync::dispatch(
            $this->universeId,
            $this->key,
            $this->type,
            $this->scope,
            $this->target,
            $value,
            $this->datastoreType
        );
    }
}
