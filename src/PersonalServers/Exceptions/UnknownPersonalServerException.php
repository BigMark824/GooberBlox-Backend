<?php

namespace GooberBlox\PersonalServers\Exceptions;

use Exception;
use Throwable;

class UnknownPersonalServerException extends Exception
{
    public function __construct(string $message = 'Unknown Personal Server.', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
