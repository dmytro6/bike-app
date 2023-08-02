<?php

declare(strict_types=1);

namespace App\Infrastructure\HttpClient\CityBikes;

use App\Domain\StationDistanceProcessing\DTO\NetworkDTO;
use App\Domain\StationDistanceProcessing\DTO\StationDTO;
use App\Infrastructure\HttpClient\Exception\ResponseParsingException;
use App\Infrastructure\HttpClient\Exception\ResponseStatusCodeException;
use App\Infrastructure\HttpClient\AbstractHttpClient;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class CityBikesHttpClient extends AbstractHttpClient implements CityBikesHttpClientInterface
{
    private const URI_NETWORKS = '/v2/networks?fields=href,location';

    public function __construct(protected ClientInterface $client, protected string $apiUri)
    {
        parent::__construct($this->client, $this->apiUri);
    }

    /**
     * @return NetworkDTO[]
     */
    public function getNetworks(): array
    {
        $request = $this->prepareNetworksRequest();
        $response = $this->send($request);
        return $this->parseNetworksResponse($response);
    }

    /**
     * @param NetworkDTO $networkDTO
     * @return StationDTO[]
     */
    public function getNetworkStations(NetworkDTO $networkDTO): array
    {
        $request = $this->prepareNetworkStationsRequest($networkDTO);
        $response = $this->send($request);

        return $this->parseNetworkStationsResponse($response);
    }

    private function prepareNetworksRequest(): RequestInterface
    {
        return new Request('GET', $this->apiUri . self::URI_NETWORKS);
    }


    private function prepareNetworkStationsRequest(NetworkDTO $networkDTO): RequestInterface
    {
        return new Request('GET', $this->apiUri . $networkDTO->getUri());
    }

    /**
     * @param ResponseInterface $response
     * @return NetworkDTO[]
     *
     * @throws ResponseStatusCodeException
     */
    private function parseNetworksResponse(ResponseInterface $response): array
    {
        if ($response->getStatusCode() !== SymfonyResponse::HTTP_OK) {
            throw new ResponseStatusCodeException($response->getStatusCode());
        }

        $data = \json_decode((string) $response->getBody(), true);

        $networkDTOCollection = [];

        foreach ($data['networks'] as $network) {
            $networkDTOCollection[] = new NetworkDTO($network['href'], $network['location']['city']);
        }

        return $networkDTOCollection;
    }

    /**
     * @param ResponseInterface $response
     * @return StationDTO[]
     *
     * @throws ResponseStatusCodeException
     */
    private function parseNetworkStationsResponse(ResponseInterface $response): array
    {
        if ($response->getStatusCode() !== SymfonyResponse::HTTP_OK) {
            throw new ResponseStatusCodeException($response->getStatusCode());
        }

        $networkStationDTOCollection = [];

        try {
            $data = \json_decode((string) $response->getBody(), true);

            foreach ($data['network']['stations'] as $station) {
                $networkStationDTOCollection[] = new StationDTO(
                    (string) $station['name'],
                    (float) $station['latitude'],
                    (float) $station['longitude'],
                    (int) $station['free_bikes']
                );
            }
        } catch (\Exception $exception) {
            throw new ResponseParsingException($exception);
        }

        return $networkStationDTOCollection;
    }
}
