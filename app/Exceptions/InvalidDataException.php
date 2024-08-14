<?php

namespace App\Exceptions;

use Exception;

class InvalidDataException extends Exception
{
    use BaseException;

    /**
     * Message
     * @return string
     */
    function message(): string
    {
        return 'Invalid data has found';
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
