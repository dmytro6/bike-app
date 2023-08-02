<?php

declare(strict_types=1);

namespace App\Infrastructure\HttpClient;

use App\Domain\StationDistanceProcessing\DTO\NetworkDTO;
use App\Domain\StationDistanceProcessing\DTO\StationDTO;
use Psr\Http\Client\ClientInterface;

interface ApiGatewayInterface
{
    /**
     * @param string $city
     * @return StationDTO[]
     */
    public function getStations(string $city): array;
}
