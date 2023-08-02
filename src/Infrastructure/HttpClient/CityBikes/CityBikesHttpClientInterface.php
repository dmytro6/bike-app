<?php

declare(strict_types=1);

namespace App\Infrastructure\HttpClient\CityBikes;

use App\Domain\StationDistanceProcessing\DTO\NetworkDTO;
use App\Domain\StationDistanceProcessing\DTO\StationDTO;
use Psr\Http\Client\ClientInterface;

interface CityBikesHttpClientInterface
{
    public function __construct(ClientInterface $client, string $apiUri);

    /**
     * @return NetworkDTO[]
     */
    public function getNetworks(): array;

    /**
     * @param NetworkDTO $networkDTO
     * @return StationDTO[]
     */
    public function getNetworkStations(NetworkDTO $networkDTO): array;
}
