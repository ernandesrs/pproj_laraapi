<?php

namespace App\Exceptions\Api\Auth;

use App\Exceptions\Api\BaseException;
use Exception;

class LoginFailException extends Exception
{
    use BaseException;

    /**
     * Message
     * @return string
     */
    function message(): string
    {
        return 'Login credentials is invalid.';
    }

    /**
     * Status code
     * @return int
     */
    function status(): int
    {
        return 422;
    }
}
