<?php

namespace GooberBlox\Library\Models;

use Cache;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use GooberBlox\Platform\Membership\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserFeed extends Model
{
    use Cachable;
    protected $fillable = [
        'user_id',
        'feed_id'
    ];

    public function Feed()
    {
        return $this->belongsTo(Feed::class);
    }
}
