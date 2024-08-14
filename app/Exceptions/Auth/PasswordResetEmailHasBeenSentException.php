<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;
use Exception;

class PasswordResetEmailHasBeenSentException extends Exception
{
    use BaseException;

    /**
     * Message
     * @return string
     */
    function message(): string
    {
        return 'An email has already been sent a short time ago.';
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
