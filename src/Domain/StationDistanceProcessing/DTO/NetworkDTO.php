<?php

declare(strict_types=1);

namespace App\Domain\StationDistanceProcessing\DTO;

readonly class NetworkDTO
{
    public function __construct(
        private string $uri,
        private string $city
    ) {}

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }
}
