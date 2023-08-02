<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\HttpClient\CityBikes;

use App\Domain\StationDistanceProcessing\DTO\NetworkDTO;
use App\Domain\StationDistanceProcessing\DTO\StationDTO;
use App\Infrastructure\HttpClient\CityBikes\CityBikesGateway;
use App\Infrastructure\HttpClient\CityBikes\CityBikesHttpClient;
use PHPUnit\Framework\TestCase;

class CityBikesGatewayTest extends TestCase
{
    private CityBikesGateway $gateway;

    private CityBikesHttpClient $client;

    public function testGetStations(): void
    {
        $expectedCity = 'Warsaw';
        $expectedNetwork = new NetworkDTO('/v2/networks/veturilo-nextbike-warsaw', $expectedCity);

        $networks = [
            new NetworkDTO('/v2/networks/cyclopolis-rhodes', 'Rhodes'),
            $expectedNetwork
        ];

        $result = [
            new StationDTO('Nestle House', 52.183992, 21.00984, 2),
            new StationDTO('UKSW', 52.296226, 20.958327, 5)
        ];

        $this->client
            ->expects(static::once())
            ->method('getNetworks')
            ->willReturn($networks);

        $this->client
            ->expects(static::once())
            ->method('getNetworkStations')
            ->with($expectedNetwork)
            ->willReturn($result);

        $this->assertEquals($result, $this->gateway->getStations($expectedCity));
    }

    protected function setUp(): void
    {
        $this->client = $this->createMock(CityBikesHttpClient::class);

        $this->gateway = new CityBikesGateway($this->client);
    }
}
