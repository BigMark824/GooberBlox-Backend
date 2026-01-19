<?php

namespace GooberBlox\Account\Enums;

enum AccountStatusEnum
{
    const OK = 1;
    const SUPPRESSED = 2;
    const DELETED = 3;
    const POISONED = 4;
    const MUST_VALIDATE_EMAIL = 5;
    const FORGOTTEN = 6;
}