<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Airport;
use App\Entity\AirportDataset;
use App\Factory\AirportDatasetFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportAirportsDatasets extends AbstractImportCommand
{
    public function __construct(
        protected AirportDatasetFactoryInterface $airportDatasetFactory,
        protected EntityManagerInterface $entityManager,
        protected LoggerInterface $logger,
        protected ValidatorInterface $validator
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();

        $this
            ->setName('import:airports-datasets')
            ->setDescription('Import airports statistic datasets from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $airport = $this->entityManager
            ->getRepository(Airport::class)
            ->findOneBy(['icaoCode' => $csv['airport']]);

        $airportDataset = $this->entityManager
            ->getRepository(AirportDataset::class)
            ->findOneBy(
                [
                    'airport' => $airport,
                    'year' => $csv['year'],
                ]
            );

        $airportDataset ??= new AirportDataset();
        $airportDataset->update($this->airportDatasetFactory->createFromCsv($csv));

        return $airportDataset;
    }

    protected function getEntityClassName(): string
    {
        return AirportDataset::class;
    }
}
