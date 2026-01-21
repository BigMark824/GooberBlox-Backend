<?php

namespace GooberBlox\Platform\Groups\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

use GooberBlox\Membership\Models\User;

use GooberBlox\Agent\Models\Agent;
use GooberBlox\Groups\Models\GroupActionType;
use GooberBlox\Platform\Groups\{GroupManagement, InitiatorUserJson};
class Group extends Model
{
    protected $_robloxUserId = config('gooberblox.users.Default.RobloxUserId');
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

    public function unlock(Group $group, User $user): void
    {
        if($group != null)
        {
            $group->is_locked = false;
            $group->save();
            
            GroupManagement::logGroupAction($this->_robloxUserId, $group->id, GroupActionType::$Unlock->id, 
                new InitiatorUserJson($user->id)
            );
        }

    }

    public function lock(Group $group, User $user): void
    {
        if($group != null)
        {
            $group->is_locked = true;
            $group->save();
            
            GroupManagement::logGroupAction($this->_robloxUserId, $group->id, GroupActionType::$Lock->id, 
                new InitiatorUserJson($user->id)
            );
        }

    }

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
