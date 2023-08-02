<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\HttpClient\CityBikes;

use App\Domain\StationDistanceProcessing\DTO\NetworkDTO;
use App\Domain\StationDistanceProcessing\DTO\StationDTO;
use App\Infrastructure\HttpClient\CityBikes\CityBikesHttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

class CityBikesHttpClientTest extends TestCase
{
    private CityBikesHttpClient $cityBikesHttpClient;

    private ClientInterface $client;

    private const API_URI = 'test-api.uri';

    private const URI_NETWORKS = '/v2/networks?fields=href,location';

    /**
     * @return void
     */
    public function testGetNetworks(): void
    {
        $response = new Response(
            status: 200,
            body: fopen('data://text/plain;base64,' . base64_encode(json_encode(
                [
                    'networks' => [
                        [
                            'href' => '/v2/networks/cyclopolis-rhodes',
                            'location' => [
                                'city' => 'Rhodes',
                            ],
                        ],
                        [
                            'href' => '/v2/networks/veturilo-nextbike-warsaw',
                            'location' => [
                                'city' => 'Warsaw',
                            ],
                        ],
                    ],
                ]
                )),'r')
        );

        $result = [
            new NetworkDTO('/v2/networks/cyclopolis-rhodes', 'Rhodes'),
            new NetworkDTO('/v2/networks/veturilo-nextbike-warsaw', 'Warsaw')
        ];

        $this->client
            ->expects(static::once())
            ->method('sendRequest')
            ->with($this->callback(
                    function (Request $request) {
                      $this->assertEquals(
                          self::API_URI . self::URI_NETWORKS,
                          $request->getUri()->getPath() . '?' . $request->getUri()->getQuery()
                      );

                      return true;
                    }
                )
            )
            ->willReturn($response);

        $this->assertEquals($result, $this->cityBikesHttpClient->getNetworks());
    }

    public function testGetNetworkStations()
    {
        $networkDTO = new NetworkDTO('/v2/networks/veturilo-nextbike-warsaw', 'Warsaw');
        $response = new Response(
            status: 200,
            body: fopen('data://text/plain;base64,' . base64_encode(json_encode(
                    [
                        'network' => [
                            'stations' => [
                                [
                                    'name' => 'Nestle House',
                                    'latitude' => 52.183992,
                                    'longitude' => 21.00984,
                                    'free_bikes' => 2
                                ],
                                [
                                    'name' => 'UKSW',
                                    'latitude' => 52.296226,
                                    'longitude' => 20.958327,
                                    'free_bikes' => 5
                                ],
                            ],
                        ],
                    ]
                )),'r')
        );
        $result = [
            new StationDTO('Nestle House', 52.183992, 21.00984, 2),
            new StationDTO('UKSW', 52.296226, 20.958327, 5)
        ];

        $this->client
            ->expects(static::once())
            ->method('sendRequest')
            ->with($this->callback(
                    function (Request $request) {
                        $this->assertEquals(self::API_URI . '/v2/networks/veturilo-nextbike-warsaw', $request->getUri()->getPath());
                        return true;
                    }
                ))
            ->willReturn($response);

        $this->assertEquals($result, $this->cityBikesHttpClient->getNetworkStations($networkDTO));
    }

    protected function setUp(): void
    {
        $this->client = $this->createMock(ClientInterface::class);

        $this->cityBikesHttpClient = new CityBikesHttpClient($this->client, self::API_URI);
    }
}
