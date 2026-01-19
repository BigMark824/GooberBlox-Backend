<?php

namespace GooberBlox\Data\Exceptions;

use Exception;

class InvalidKeyException extends Exception
{
    protected $message = 'Private/Public Key format is incorrect.';
}
