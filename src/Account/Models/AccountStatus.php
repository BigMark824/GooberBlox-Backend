<?php

namespace GooberBlox\Account\Models;

use Illuminate\Database\Eloquent\Model;

use GooberBlox\Account\Enums\AccountStatusEnum;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class AccountStatus extends Model
{
    use Cachable;
    protected $table = 'account_statuses';
    protected $fillable = [
        'value',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class, 'account_status_id');
    }
}
