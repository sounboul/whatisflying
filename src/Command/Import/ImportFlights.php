<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Flight;
use App\Factory\FlightFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportFlights extends AbstractImportCommand
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected FlightFactoryInterface $flightFactory,
        protected LoggerInterface $logger,
        protected ValidatorInterface $validator
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();

        $this
            ->setName('import:flights')
            ->setDescription('Import flights from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $entity = $this->entityManager
            ->getRepository(Flight::class)
            ->findOneBy(['flightNumber' => $csv['flight_number']]);

        $entity ??= new Flight();
        $entity->update($this->flightFactory->createFromCsv($csv));

        return $entity;
    }

    protected function getEntityClassName(): string
    {
        return Flight::class;
    }
}
