<?php

namespace GooberBlox\Platform\Email\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;

use GooberBlox\Account\Models\Account;

/**
 * Outlines the Email model class
 * 
 * @property int $id
 * @property string $email
 * @property bool $is_blacklisted
 * @property bool $is_verified
 * @property bool $is_current
 * Relationships
 * @property-read Account|null $account
 */
class Email extends Model
{
    use Cachable;
    protected $fillable = [
        'email',
        'account_id',
        'is_verified',
        'is_current',
        'is_blacklisted'
    ];

    /**
     * Returns the account belonging to the email
     * @return BelongsTo<Account, Email>
     */
    public function account() : BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
