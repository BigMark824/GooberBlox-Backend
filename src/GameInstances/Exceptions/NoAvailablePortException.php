<?php

namespace GooberBlox\GameInstances\Exceptions;

use Exception;
use Throwable;

class NoAvailablePortException extends Exception
{
    public function __construct(string $message = 'No available ports found.', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}