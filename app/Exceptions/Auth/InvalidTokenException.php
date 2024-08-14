<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;
use Exception;

class InvalidTokenException extends Exception
{
    use BaseException;

    /**
     * Message
     * @return string
     */
    function message(): string
    {
        return 'The token sent is invalid or expired.';
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
