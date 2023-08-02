<?php

declare(strict_types=1);

namespace App\Domain\StationDistanceProcessing\DTO;

readonly class BikeGroupDTO
{
    public function __construct(
        private int $count,
        private float $latitude,
        private float $longitude
    ) {}

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
