<?php

namespace GooberBlox\Group\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

use GooberBlox\Agent\Models\Agent;
class Group extends Model
{
    protected $fillable = [
        'name',
        'agent_id',
        'creator_type',
        'owner_user_id',
        'previous_user_id',
        'description',
        'emblem_id',
        'public_entry_allowed',
        'bc_only_join',
        'is_locked'
    ];

    public function agent(): MorphOne
    {
        return $this->morphOne(
            Agent::class,
            'target',
            'agent_type',
            'agent_target_id'
        );
    }
}
