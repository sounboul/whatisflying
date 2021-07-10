<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Airport;
use App\Entity\AirportFrequency;
use App\Traits\CsvParserTrait;
use Doctrine\ORM\EntityManagerInterface;

final class AirportFrequencyFactory implements AirportFrequencyFactoryInterface
{
    use CsvParserTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createFromCsv(array $csv): AirportFrequency
    {
        $airportFrequency = new AirportFrequency();

        if (!is_null($airport = $this->parseString($csv['airport']))) {
            $airport = $this->entityManager
                ->getRepository(Airport::class)
                ->findOneBy(['icaoCode' => $airport]);

            if (!is_null($airport)) {
                $airportFrequency->setAirport($airport);
            }
        }

        if (!is_null($description = $this->parseString($csv['description']))) {
            $airportFrequency->setDescription($description);
        }

        if (!is_null($frequency = $this->parseInt($csv['frequency']))) {
            $airportFrequency->setFrequency($frequency);
        }

        if (!is_null($type = $this->parseString($csv['type']))) {
            $airportFrequency->setType(strtoupper($type));
        }

        return $airportFrequency;
    }
}
