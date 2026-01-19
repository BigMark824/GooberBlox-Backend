<?php

namespace GooberBlox\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

use GooberBlox\Account\Models\Account;
use GooberBlox\Agent\Models\Agent;
class User extends Model
{
    protected $fillable = [
        'account_id',
        'age_bracket',
        'age_bracket_is_locked',
        'birth_date',
        'use_super_safe_conversation_mode',
        'use_super_privacy_mode',
        'conversation_safety_mode_is_locked',
        'privacy_safety_mode_is_locked'
    ];
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
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
