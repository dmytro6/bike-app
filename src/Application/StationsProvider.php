<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\StationDistanceProcessing\DTO\StationDTO;
use App\Infrastructure\HttpClient\ApiGatewayInterface;

class StationsProvider
{
    public function __construct(private ApiGatewayInterface $apiGateway) {}

    /**
     * @param string $city
     * @return StationDTO[]
     */
    public function getStations(string $city): array
    {
        return $this->apiGateway->getStations($city);
    }
}
