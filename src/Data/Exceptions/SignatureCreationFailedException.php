<?php

namespace GooberBlox\Data\Exceptions;

use Exception;

class SignatureCreationFailedException extends Exception
{
    protected $message = 'Failed to generate signature.';
}
