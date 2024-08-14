<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;
use Exception;

class EmailHasAlreadyBeenVerifiedException extends Exception
{
    use BaseException;

    /**
     * Message
     * @return string
     */
    function message(): string
    {
        return 'Email is already verified.';
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
