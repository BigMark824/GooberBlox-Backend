<?php

namespace GooberBlox\Assets\Exceptions;

use Exception;
use Throwable;

class UnknownAssetException extends Exception
{
    public function __construct(?int $id = null)
    {
        $message = $id === null
            ? 'Unknown Asset'
            : 'Unknown Asset ' . $id;

        parent::__construct($message);
    }
}