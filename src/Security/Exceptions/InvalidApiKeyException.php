<?php

namespace GooberBlox\Security\Exceptions;

use Exception;
use Throwable;

class InvalidApiKeyException extends Exception
{
    public function __construct(string $message = 'API Key is Invalid.', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}