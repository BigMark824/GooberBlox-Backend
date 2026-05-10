<?php

namespace GooberBlox\Agent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

use GooberBlox\Agent\Enums\AgentType;
use GooberBlox\Platform\Membership\Models\User;
use GooberBlox\Platform\Groups\Models\Group;
class Agent extends Model
{
    protected $fillable = [
        'agent_type',
        'agent_target_id'
    ];
    public function target(): MorphTo
    {
        return $this->morphTo(
            __FUNCTION__,
            'agent_type',
            'agent_target_id'
        );
    }
}
