<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\AircraftType;
use App\Factory\AircraftTypeFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportAircraftTypes extends AbstractImportCommand
{
    public function __construct(
        protected AircraftTypeFactoryInterface $aircraftTypeFactory,
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
            ->setName('import:aircraft-types')
            ->setDescription('Import aircraft types from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $aircraftType = $this->entityManager
            ->getRepository(AircraftType::class)
            ->findOneBy(['icaoCode' => $csv['icao_code']]);

        $aircraftType ??= new AircraftType();
        $aircraftType->update($this->aircraftTypeFactory->createFromCsv($csv));

        return $aircraftType;
    }

    protected function getEntityClassName(): string
    {
        return AircraftType::class;
    }
}
