<?php

namespace GooberBlox\Library\PremiumFeatures\Models;

use Illuminate\Database\Eloquent\Model;

class PremiumFeature extends Model
{
    protected $fillable = [
        'name',
        'account_add_on_type_id',
        'duration_type_id',
        'is_renewal',
        'robux_credit_quantity_type_id',
        'robux_stipend_quantity_type_id',
        'robux_stipend_frequency_type_id',
        'showcase_allotment_type_id',
        'content_privilege_type_id',
        'advertising_suppression_type_id',
        'granted_asset_list_id',
        'granted_badge_list_id',
        'granted_item_list_id'
    ];
}
