<?php

namespace App\Exceptions\Api\Auth;

use App\Exceptions\Api\BaseException;
use Exception;

class VerificationEmailHasBeenSentException extends Exception
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
