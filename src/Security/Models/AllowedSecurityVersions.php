<?php

namespace GooberBlox\Security\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class AllowedSecurityVersions extends Model
{
    use Cachable;
    protected $fillable = [
        'version'
    ];
    public function allowedMd5Hashes()
    {
        return $this->hasMany(AllowedMD5Hashes::class, 'version_id');
    }
}
