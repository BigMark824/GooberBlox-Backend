<?php

namespace GooberBlox\Security\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

use GooberBlox\Security\Models\AllowedSecurityVersions;
class AllowedMD5Hashes extends Model
{
    protected $table = "allowed_md5_hashes";
    protected $fillable = [
        'md5_hash',
        'version_id'
    ];

    public function allowedSecurityVersion()
    {
        return $this->belongsTo(AllowedSecurityVersions::class, 'version_id');
    }
}
