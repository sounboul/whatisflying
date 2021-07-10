<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Aircraft;
use App\Factory\AircraftFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportAircraft extends AbstractImportCommand
{
    public function __construct(
        protected AircraftFactoryInterface $aircraftFactory,
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
            ->setName('import:aircraft')
            ->setDescription('Import aircraft from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $aircraft = $this->entityManager
            ->getRepository(Aircraft::class)
            ->findOneBy(['icao24bitAddress' => $csv['icao_24bit_address']]);

        $aircraft ??= new Aircraft();
        $aircraft->update($this->aircraftFactory->createFromCsv($csv));

        return $aircraft;
    }

    protected function getEntityClassName(): string
    {
        return Aircraft::class;
    }
}
