<?php

namespace GooberBlox\Platform\Infrastructure\Exceptions;

use Exception;
use Throwable;

class NoAvailableServerException extends Exception
{
    public function __construct(string $message = 'No available servers found.', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}