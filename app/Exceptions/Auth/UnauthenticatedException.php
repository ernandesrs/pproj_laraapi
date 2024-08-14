<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;
use Exception;

class UnauthenticatedException extends Exception
{
    use BaseException;

    /**
     * Message
     * @return string
     */
    function message(): string
    {
        return 'You are not authenticated.';
    }

    /**
     * Status code
     * @return int
     */
    function status(): int
    {
        return 401;
    }
}
