<?php

declare (strict_types=1);

namespace App\Infrastructure\HttpClient\Exception;

/**
 * Exception is thrown when gateway responds with any other code than 200 HTTP OK.
 */
class ResponseStatusCodeException extends \RuntimeException
{
    /**
     * @param int $code
     */
    public function __construct(int $code)
    {
        parent::__construct(sprintf('HTTP Client responded with status code %d', $code));
    }
}
