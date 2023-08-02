<?php

declare(strict_types=1);

namespace App\Infrastructure\FileSystem;

use App\Domain\StationDistanceProcessing\DTO\BikeGroupDTO;

interface FiletypeAdapterInterface
{
    public function __construct(
        string $path,
        string $projectDir
    );

    /**
     * @return \Generator|null
     */
    public function getBikerGroupGenerator(): \Generator|null;
}
