<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use App\Factory\AircraftModelFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportAircraftModels extends AbstractImportCommand
{
    public function __construct(
        protected AircraftModelFactoryInterface $aircraftModelFactory,
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
            ->setName('import:aircraft-models')
            ->setDescription('Import aircraft models from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $aircraftType = $this->entityManager
            ->getRepository(AircraftType::class)
            ->findOneBy(['icaoCode' => $csv['aircraft_type']]);

        $aircraftModel = $this->entityManager
            ->getRepository(AircraftModel::class)
            ->findOneBy(
                [
                    'aircraftType' => $aircraftType,
                    'engineManufacturer' => $csv['engine_manufacturer'],
                    'name' => $csv['name'],
                ]
            );

        $aircraftModel ??= new AircraftModel();
        $aircraftModel->update($this->aircraftModelFactory->createFromCsv($csv));

        return $aircraftModel;
    }

    protected function getEntityClassName(): string
    {
        return AircraftModel::class;
    }
}
