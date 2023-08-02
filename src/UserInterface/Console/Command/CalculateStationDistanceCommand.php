<?php

declare (strict_types=1);

namespace App\UserInterface\Console\Command;

use App\Domain\StationDistanceProcessing\DTO\StationDistanceAggregateDTO;
use App\Service\StationDistancesService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'station:distance:calculate',
    description: 'Calculate batch of distances to the closest bike station',
    hidden: false
)]
class CalculateStationDistanceCommand extends Command
{
    public function __construct(private StationDistancesService $stationDistanceService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('city', InputArgument::REQUIRED, 'City');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stationDistancesArray = $this->stationDistanceService->processStationDistances((string) $input->getArgument('city'));

        foreach ($stationDistancesArray as $stationDistanceAggregate)
        {
            /** @var StationDistanceAggregateDTO $stationDistanceAggregate */
            $output->writeln(\sprintf('distance: %s', $stationDistanceAggregate->getDistance()));
            $output->writeln(\sprintf('name: %s', $stationDistanceAggregate->getName()));
            $output->writeln(\sprintf('free_bike_count: %s', $stationDistanceAggregate->getFreeBikeCount()));
            $output->writeln(\sprintf('biker_count: %s', $stationDistanceAggregate->getBikerCount()));
            $output->writeln('');
        }

        return Command::SUCCESS;
    }
}
