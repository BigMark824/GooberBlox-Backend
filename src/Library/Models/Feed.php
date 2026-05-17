<?php

namespace GooberBlox\Library\Models;

use Cache;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use GooberBlox\Platform\Membership\Models\User;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use Cachable;
    protected $fillable = [
        'user_id',
        'item_id',
        'item_type',
        'action_type',
        'description',
        'action_date',
        'harvest_date'
    ];

    protected $casts = [
        'action_date' => 'datetime',
        'harvest_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function viewers()
    {
        return $this->belongsToMany(User::class, 'user_feeds');
    }

    public static function createNew(int $userId, int $itemId, ?string $itemType, string $actionType, string $description): self
    {
        return self::create([
            'user_id' => $userId,
            'item_id' => $itemId,
            'item_type' => $itemType,
            'action_type' => $actionType,
            'description' => $description,
            'action_date' => now(),
            'harvest_date' => now()->subDay(),
        ]);
    }   

    public static function getFeedForViewer(int $userId)
    {
        return Cache::remember(
            "viewer_feed:{$userId}",
            300,
            fn() => self::query()
                ->select('feeds.*')
                ->join('user_feeds', 'feeds.id', '=', 'user_feeds.feed_id')
                ->where('user_feeds.user_id', $userId)
                ->latest('action_date')
                ->limit(20)
                ->get()
        );
    }

    public static function getFeedsByUserAndActionType(int $userId, string $actionType, int $limit = 20)
    {
        return Cache::remember(
            "feed:user:{$userId}:action:{$actionType}:{$limit}",
            300,
            fn() => self::where('user_id', $userId)
                ->where('action_type', $actionType)
                ->latest('action_date')
                ->limit($limit)
                ->get()
        );
    }

    public static function createStatusFeed(User $actor, string $message): Feed 
    {
        $statusType = FeedType::status()?->type ?? 'status';

        $feed = self::createNew(
            userId: $actor->id,
            itemId: 0,
            itemType: null,
            actionType: $statusType,
            description: trim($message)
        );

        UserFeed::firstOrCreate([
            'user_id' => $actor->id,
            'feed_id' => $feed->id
        ]);

        return $feed;
    }
}
