<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Airline;
use App\Factory\AirlineFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportAirlines extends AbstractImportCommand
{
    public function __construct(
        protected AirlineFactoryInterface $airlineFactory,
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
            ->setName('import:airlines')
            ->setDescription('Import airlines from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $entity = $this->entityManager
            ->getRepository(Airline::class)
            ->findOneBy(['icaoCode' => $csv['icao_code']]);

        $entity ??= new Airline();
        $entity->update($this->airlineFactory->createFromCsv($csv));

        return $entity;
    }

    protected function getEntityClassName(): string
    {
        return Airline::class;
    }
}
