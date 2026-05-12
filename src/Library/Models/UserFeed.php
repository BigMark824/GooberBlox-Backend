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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }

    public function scopeStatus($query)
    {
        return $query->whereHas('feed', function($q)
        {
            $q->where('action_type', FeedType::status()->id);
        });
    }

}
