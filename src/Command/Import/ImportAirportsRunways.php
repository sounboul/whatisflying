<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Airport;
use App\Entity\AirportRunway;
use App\Factory\AirportRunwayFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportAirportsRunways extends AbstractImportCommand
{
    public function __construct(
        protected AirportRunwayFactoryInterface $airportRunwayFactory,
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
            ->setName('import:airports-runways')
            ->setDescription('Import airports runways from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $airport = $this->entityManager
            ->getRepository(Airport::class)
            ->findOneBy(['icaoCode' => $csv['airport']]);

        $airportRunway = $this->entityManager
            ->getRepository(AirportRunway::class)
            ->findOneBy(
                [
                    'airport' => $airport,
                    'heName' => $csv['he_name'],
                    'leName' => $csv['le_name'],
                ]
            );

        $airportRunway ??= new AirportRunway();
        $airportRunway->update($this->airportRunwayFactory->createFromCsv($csv));

        return $airportRunway;
    }

    protected function getEntityClassName(): string
    {
        return AirportRunway::class;
    }
}
