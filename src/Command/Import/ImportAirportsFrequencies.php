<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Airport;
use App\Entity\AirportFrequency;
use App\Factory\AirportFrequencyFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportAirportsFrequencies extends AbstractImportCommand
{
    public function __construct(
        protected AirportFrequencyFactoryInterface $airportFrequencyFactory,
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
            ->setName('import:airports-frequencies')
            ->setDescription('Import airports radio frequencies from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $airport = $this->entityManager
            ->getRepository(Airport::class)
            ->findOneBy(['icaoCode' => $csv['airport']]);

        $airportFrequency = $this->entityManager
            ->getRepository(AirportFrequency::class)
            ->findOneBy(
                [
                    'airport' => $airport,
                    'frequency' => $csv['frequency'],
                    'type' => $csv['type'],
                ]
            );

        $airportFrequency ??= new AirportFrequency();
        $airportFrequency->update($this->airportFrequencyFactory->createFromCsv($csv));

        return $airportFrequency;
    }

    protected function getEntityClassName(): string
    {
        return AirportFrequency::class;
    }
}
