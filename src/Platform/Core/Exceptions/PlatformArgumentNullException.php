<?php

namespace GooberBlox\Platform\Core\Exceptions;

use Exception;
use Throwable;

class PlatformArgumentNullException extends Exception
{
    public function __construct(string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}