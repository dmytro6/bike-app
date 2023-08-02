<?php

declare (strict_types=1);

namespace App\Infrastructure\HttpClient\Exception;

/**
 * Exception is thrown when gateway responds with any other code than 200 HTTP OK.
 */
class ResponseParsingException extends \RuntimeException
{
    public function __construct(\Exception $exception)
    {
        parent::__construct('Unexpected API response data format', 0, $exception);
    }
}
