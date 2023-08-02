<?php

declare(strict_types=1);

namespace App\Domain\StationDistanceProcessing\DTO;

readonly class StationDistanceAggregateDTO
{
    public function __construct(
        private float $distance,
        private string $name,
        private int $freeBikeCount,
        private int $bikerCount
    ) {}

    /**
     * @return float
     */
    public function getDistance(): float
    {
        return $this->distance;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getFreeBikeCount(): int
    {
        return $this->freeBikeCount;
    }

    /**
     * @return int
     */
    public function getBikerCount(): int
    {
        return $this->bikerCount;
    }
}
