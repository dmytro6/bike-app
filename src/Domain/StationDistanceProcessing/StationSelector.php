<?php

declare(strict_types=1);

namespace App\Domain\StationDistanceProcessing;

use App\Domain\StationDistanceProcessing\DTO\BikeGroupDTO;
use App\Domain\StationDistanceProcessing\DTO\StationDistanceAggregateDTO;
use App\Domain\StationDistanceProcessing\DTO\StationDTO;

class StationSelector
{
    private const DEFAULT_DISTANCE = 9999999999999999;
    private const DEFAULT_STATION_NAME = '';
    private const DEFAULT_LATITUDE = 0;
    private const DEFAULT_LONGITUDE = 0;
    private const DEFAULT_FREE_BIKE_COUNT = 0;

    public function __construct() {}

    /**
     * @param StationDTO[] $stations
     * @param BikeGroupDTO $bikerGroup
     * @return StationDistanceAggregateDTO
     */
    public static function chooseClosestStation(array $stations, BikeGroupDTO $bikerGroup): StationDistanceAggregateDTO
    {
        $closestStation = self::getDefaultStation();
        $shortestDistance = self::DEFAULT_DISTANCE;

        foreach ($stations as $station) {
            $distance = DistanceCalculator::calculate(
                $station->getLatitude(),
                $station->getLongitude(),
                $bikerGroup->getLatitude(),
                $bikerGroup->getLongitude()
            );

            if ($distance < $shortestDistance) {
                $closestStation = $station;
                $shortestDistance = $distance;
            }
        }

        return new StationDistanceAggregateDTO(
            $shortestDistance,
            $closestStation->getName(),
            $closestStation->getFreeBikeCount(),
            $bikerGroup->getCount()
        );
    }

    private static function getDefaultStation(): StationDTO
    {
        return new StationDTO(
            self::DEFAULT_STATION_NAME,
            self::DEFAULT_LATITUDE,
            self::DEFAULT_LONGITUDE,
            self::DEFAULT_FREE_BIKE_COUNT
        );
    }
}
