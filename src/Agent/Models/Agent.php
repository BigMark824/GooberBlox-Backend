<?php

namespace GooberBlox\Agent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

use GooberBlox\Agent\Enums\AgentType;
use GooberBlox\User\Models\User;
use GooberBlox\Group\Models\Group;
class Agent extends Model
{
    protected $fillable = [
        'agent_type',
        'agent_target_id'
    ];
    protected static function boot(): void
    {
        parent::boot();

        static::retrieved(function ($agent) {
            $agent->agent_type = match ($agent->agent_type) {
                AgentType::User->value => User::class,
                AgentType::Group->value => Group::class,
                default => null,
            };
        });
    }
    public function target(): MorphTo
    {
        return $this->morphTo(
            __FUNCTION__,
            'agent_type',
            'agent_target_id'
        );
    }
}
