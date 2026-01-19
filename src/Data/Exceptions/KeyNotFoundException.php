<?php

namespace GooberBlox\Data\Exceptions;

use Exception;

class KeyNotFoundException extends Exception
{
    protected $message = 'Private/Public Key not found.';
}
