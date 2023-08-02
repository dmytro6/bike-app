<?php

declare(strict_types=1);

namespace App\Infrastructure\HttpClient\CityBikes;

use App\Domain\StationDistanceProcessing\DTO\NetworkDTO;
use App\Domain\StationDistanceProcessing\DTO\StationDTO;
use App\Infrastructure\HttpClient\ApiGatewayInterface;
use App\Infrastructure\HttpClient\Exception\NetworkNotFoundException;

class CityBikesGateway implements ApiGatewayInterface
{
    public function __construct(private CityBikesHttpClient $client)
    {}

    /**
     * @param string $city
     * @return StationDTO[]
     */
    public function getStations(string $city): array
    {
        $networks = $this->client->getNetworks();
        return $this->client->getNetworkStations($this->findNetworkByCity($networks, $city));
    }

    private function findNetworkByCity(array $networks, string $city): NetworkDTO
    {
        foreach ($networks as $network) {
            if (trim(strtolower($network->getCity())) === strtolower($city)) {
                return $network;
            }
        }

        throw new NetworkNotFoundException($city);
    }
}
