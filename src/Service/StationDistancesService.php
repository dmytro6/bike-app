<?php

declare(strict_types=1);

namespace App\Service;

use App\Domain\StationDistanceProcessing\StationDistanceAggregationProcessor;

class StationDistancesService
{
    public function __construct(private StationDistanceAggregationProcessor $processor) {}

    public function processStationDistances(string $city): array
    {
        return $this->processor->process($city);
    }
}
