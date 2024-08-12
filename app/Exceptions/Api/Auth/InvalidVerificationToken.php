<?php

namespace App\Exceptions\Api\Auth;

use App\Exceptions\Api\BaseException;
use Exception;

class InvalidVerificationToken extends Exception
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
