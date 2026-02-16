<?php

namespace GooberBlox\Platform\Groups\Exceptions;

use Exception;
use Throwable;

class UnknownGroupException extends Exception
{
    public function __construct(?int $id = null)
    {
        $message = $id === null
            ? 'Unknown Asset'
            : 'Unknown Asset ' . $id;

        parent::__construct($message);
    }
}