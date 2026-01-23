<?php

namespace GooberBlox\Account\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use GooberBlox\Account\Enums\AccountStatusEnum;
use GooberBlox\Account\Models\AccountStatus;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class Account extends Authenticatable
{
    use Notifiable, Cachable;

    protected $table = 'accounts';
    protected $fillable = [
        'name',
        'description',
        'password',
        'account_status_id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function user()
    {
        return $this->hasOne(\GooberBlox\Membership\Models\User::class,'account_id');
    }
    public function accountStatus()
    {
        return $this->belongsTo(AccountStatus::class, 'account_status_id'); 
    }
}
