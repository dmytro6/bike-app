<?php

declare(strict_types=1);

namespace App\Infrastructure\FileSystem;

use App\Domain\StationDistanceProcessing\DTO\BikeGroupDTO;
use App\Infrastructure\FileSystem\Exception\FileParsingException;

Class CsvAdapter implements FiletypeAdapterInterface
{
    public function __construct(public string $path, public string $projectDir)
    {}

    /**
     * @return \Generator|null
     */
    public function getBikerGroupGenerator(): \Generator|null
    {
        try {
            $generator = $this->getLinesFromFile($this->projectDir . $this->path);
            $generator->next();

            return $generator;

        } catch (\Exception $exception) {
            throw new FileParsingException($exception);
        }
    }

    private function getLinesFromFile($path): \Generator|null
    {
        if (!$fileHandle = fopen($path, 'r')) {
            return null;
        }

        while (false !== $line = fgets($fileHandle)) {
            yield $this->parseLine($line);
        }

        fclose($fileHandle);
    }

    private function parseLine(string $line): BikeGroupDTO
    {
        $bikerInfo = explode(',', $line);
        return new BikeGroupDTO(
            (int) trim($bikerInfo[0]),
            (float) trim($bikerInfo[1]),
            (float) trim($bikerInfo[2])
        );
    }
}
