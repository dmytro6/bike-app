<?php

declare(strict_types=1);

namespace App\Application;

use App\Infrastructure\FileSystem\FiletypeAdapterInterface;

class BikerGroupGeneratorProvider
{
    public function __construct(private FiletypeAdapterInterface $adapter) {}

    /**
     * @return \Generator|null
     */
    public function getBikerGroupGenerator(): \Generator|null
    {
        return $this->adapter->getBikerGroupGenerator();
    }
}
