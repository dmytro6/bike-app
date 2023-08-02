<?php

declare(strict_types=1);

namespace App\Infrastructure\HttpClient;

use Psr\Http\Client\ClientInterface;

interface HttpClientInterface
{
    public function __construct(ClientInterface $client, string $apiUri);
}
