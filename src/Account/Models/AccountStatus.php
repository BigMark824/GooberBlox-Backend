<?php

namespace GooberBlox\Account\Models;

use Illuminate\Database\Eloquent\Model;

use GooberBlox\Account\Enums\AccountStatusEnum;
class AccountStatus extends Model
{

    protected $table = 'account_statuses';
    protected $fillable = [
        'value',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class, 'account_status_id');
    }
}
