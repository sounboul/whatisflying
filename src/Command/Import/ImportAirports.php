<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Airport;
use App\Factory\AirportFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportAirports extends AbstractImportCommand
{
    public function __construct(
        protected AirportFactoryInterface $airportFactory,
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
            ->setName('import:airports')
            ->setDescription('Import airports from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $airport = $this->entityManager
            ->getRepository(Airport::class)
            ->findOneBy(['icaoCode' => $csv['icao_code']]);

        $airport ??= new Airport();
        $airport->update($this->airportFactory->createFromCsv($csv));

        return $airport;
    }

    protected function getEntityClassName(): string
    {
        return Airport::class;
    }
}
