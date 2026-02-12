<?php

namespace GooberBlox\Platform\Infrastructure\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class ServerFarm extends Model
{
    use Cachable;
    protected $fillable = [
        'name',
        'server_type_id',
        'abbreviation'
    ];
}
