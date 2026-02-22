<?php

namespace GooberBlox\Library\PremiumFeatures\Models;

use Illuminate\Database\Eloquent\Model;

class AccountAddOn extends Model
{
    protected $fillable = [
        'account_id',
        'premium_feature_id',
        'renewal',
        'expiration',
        'robux_stipend_id',
        'lease_expiration',
        'worker_id',
        'completed',
        'renewed_since'
    ];
}
