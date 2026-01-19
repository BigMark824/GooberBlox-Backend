<?php

namespace GooberBlox\Universes\Exceptions;

use Exception;
use Throwable;

class UnknownUniverseException extends Exception
{
    public function __construct(?int $id = null)
    {
        $message = $id === null
            ? 'Unknown Universe'
            : 'Unknown Universe ' . $id;

        parent::__construct($message);
    }
}