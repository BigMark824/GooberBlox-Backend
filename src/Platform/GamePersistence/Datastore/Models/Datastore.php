<?php

namespace GooberBlox\Platform\GamePersistence\Datastore\Models;

use Illuminate\Database\Eloquent\Model;

class Datastore extends Model
{
    protected $fillable = [
        'place_id',
        'key',
        'type',
        'scope',
        'target',
        'value',
        'datastore_type'
    ];
}
