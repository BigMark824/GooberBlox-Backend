<?php

namespace GooberBlox\Platform\GamePersistence\Datastore\Exceptions;

use Exception;
use Throwable;

class UnknownDatastoreValueException extends Exception
{
    public function __construct(string $message = 'Datastore entry not found.', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}