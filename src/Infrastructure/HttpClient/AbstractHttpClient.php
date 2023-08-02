<?php

declare(strict_types=1);

namespace App\Infrastructure\HttpClient;

use App\Infrastructure\HttpClient\Exception\HttpRequestSendingException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractHttpClient implements HttpClientInterface
{
    public function __construct(protected ClientInterface $client, protected string $apiUri) {}

    protected function send(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $exception) {
            throw new HttpRequestSendingException($request, $exception);
        }
    }
}
