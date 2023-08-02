<?php

declare(strict_types=1);

namespace App\Domain\StationDistanceProcessing;

use App\Application\BikerGroupGeneratorProvider;
use App\Application\StationsProvider;
use App\Domain\StationDistanceProcessing\DTO\StationDistanceAggregateDTO;

class StationDistanceAggregationProcessor
{
    public function __construct(
        private StationsProvider $stationsProvider,
        private BikerGroupGeneratorProvider $bikerGroupGeneratorProvider
    ) {}

    /**
     * @param string $city
     * @return StationDistanceAggregateDTO[]
     */
    public function process(string $city): array
    {
        $stationDistanceAggregateArray = [];
        $stations = $this->stationsProvider->getStations($city);
        $bikerGroupGenerator = $this->bikerGroupGeneratorProvider->getBikerGroupGenerator();

        while ($bikerGroupGenerator->valid()) {
            $stationDistanceAggregateArray[] = StationSelector::chooseClosestStation($stations, $bikerGroupGenerator->current());
            $bikerGroupGenerator->next();
        }

        return $stationDistanceAggregateArray;
    }
}
