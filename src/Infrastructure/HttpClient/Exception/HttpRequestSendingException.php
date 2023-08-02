<?php

declare (strict_types=1);

namespace App\Infrastructure\HttpClient\Exception;

use Psr\Http\Message\RequestInterface;

/**
 * Exception is thrown when there is an error reaching the client
 *
 */
class HttpRequestSendingException extends \RuntimeException
{
    public function __construct(RequestInterface $request, \Throwable $previous = null)
    {
        parent::__construct(
            sprintf(
                'Error while trying to access the client with %s: %s',
                $request->getMethod(),
                $request->getUri()->getHost() . $request->getUri()->getPath(),
            ),
            0,
            $previous
        );
    }
}
