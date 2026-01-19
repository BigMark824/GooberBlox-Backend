<?php

namespace GooberBlox\Account\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use GooberBlox\Account\Enums\AccountStatusEnum;
use GooberBlox\Account\Models\AccountStatus;
class Account extends Authenticatable
{
    use Notifiable;

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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($account) {
            if (empty($account->account_status_id)) {

                $accountStatus = AccountStatus::firstOrCreate(
                    ['value' => AccountStatusEnum::OK]
                );

                $account->account_status_id = $accountStatus->id;
            }
        });
    }

    public function user()
    {
        return $this->hasOne(\GooberBlox\User\Models\User::class,'account_id');
    }
    public function accountStatus()
    {
        return $this->belongsTo(AccountStatus::class, 'account_status_id'); 
    }
}
