<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedActionException extends Exception
{
    use BaseException;

    /**
     * Message
     * @return string
     */
    function message(): string
    {
        return 'This action is not authorized.';
    }

    /**
     * Status code
     * @return int
     */
    function status(): int
    {
        return 403;
    }
}
