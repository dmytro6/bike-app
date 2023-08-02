<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\StationDistanceProcessing;

use App\Domain\StationDistanceProcessing\DistanceCalculator;
use PHPUnit\Framework\TestCase;

class DistanceCalculatorTest extends TestCase
{
    /**
     * @param float $latitude1
     * @param float $longitude1
     * @param float $latitude2
     * @param float $longitude2
     * @return void
     *
     * @dataProvider testCalculateProvider
     */
    public function testCalculate(float $latitude1, float $longitude1, float $latitude2, float $longitude2, $distance): void
    {
        static::assertEquals($distance, DistanceCalculator::calculate($latitude1, $longitude1, $latitude2, $longitude2));
    }

    protected function testCalculateProvider(): array
    {
        return [
            [52.257790, 21.051500, 52.25965, 21.0529, 0.22771729568741392],
            [52.231441, 21.016399, 52.231056, 21.016738, 0.048638719486410464],
            [52.211441, 20.966399, 52.208386, 20.96311, 0.4069623218361078],
            [52.211441, 21.016399, 52.191678, 20.868969, 10.28483331160798]
        ];
    }
}
