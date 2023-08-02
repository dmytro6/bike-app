<?php

declare(strict_types=1);

namespace App\Domain\StationDistanceProcessing;

class DistanceCalculator
{
    private const EARTH_RADIUS = 6371;

    public static function calculate(float $latitude1, float $longitude1, float $latitude2, float $longitude2): float
    {
        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        $d = self::EARTH_RADIUS * $c;

        return $d;
    }
}
