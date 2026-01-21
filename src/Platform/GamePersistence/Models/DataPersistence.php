<?php

namespace GooberBlox\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class DataPersistence extends Model
{
    protected $table = "data_persistence";
    protected $fillable = [
        'agent_id',
        'universe_id',
        'blob'
    ];      

}
