<?php

declare (strict_types=1);

namespace App\Infrastructure\HttpClient\Exception;

/**
 * Exception is thrown when gateway responds with any other code than 200 HTTP OK.
 */
class NetworkNotFoundException extends \RuntimeException
{
    public function __construct(string $city)
    {
        parent::__construct(sprintf('Network not found in the city: %s', $city));
    }
}
