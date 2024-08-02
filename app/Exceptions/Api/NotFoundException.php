<?php

namespace App\Exceptions\Api;

use Exception;

class NotFoundException extends Exception
{
    use BaseException;

    /**
     * Message
     * @return string
     */
    function message(): string
    {
        return 'Not found.';
    }

    /**
     * Status code
     * @return int
     */
    function status(): int
    {
        return 404;
    }
}
