<?php

declare(strict_types=1);

namespace App\Domain\StationDistanceProcessing\DTO;

readonly class StationDTO
{
    public function __construct(
        private string $name,
        private float $latitude,
        private float $longitude,
        private int $freeBikeCount
    ) {}

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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

    /**
     * @return int
     */
    public function getFreeBikeCount(): int
    {
        return $this->freeBikeCount;
    }
}
