<?php

namespace GooberBlox\Platform\Core\Exceptions;

use Exception;
use Throwable;

class PlatformArgumentException extends Exception
{
    public function __construct(string $message, int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}