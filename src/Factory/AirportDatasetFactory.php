<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Airport;
use App\Entity\AirportDataset;
use App\Traits\CsvParserTrait;
use Doctrine\ORM\EntityManagerInterface;

final class AirportDatasetFactory implements AirportDatasetFactoryInterface
{
    use CsvParserTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createFromCsv(array $csv): AirportDataset
    {
        $airportDataset = new AirportDataset();

        if (!is_null($airport = $this->parseString($csv['airport']))) {
            $airport = $this->entityManager
                ->getRepository(Airport::class)
                ->findOneBy(['icaoCode' => $airport]);

            if (!is_null($airport)) {
                $airportDataset->setAirport($airport);
            }
        }

        if (!is_null($domesticDepartures = $this->parseInt($csv['domestic_departures']))) {
            $airportDataset->setDomesticDepartures($domesticDepartures);
        }

        if (!is_null($domesticDestinations = $this->parseInt($csv['domestic_destinations']))) {
            $airportDataset->setDomesticDestinations($domesticDestinations);
        }

        if (!is_null($internationalDepartures = $this->parseInt($csv['international_departures']))) {
            $airportDataset->setInternationalDepartures($internationalDepartures);
        }

        if (!is_null($internationalDestinations = $this->parseInt($csv['international_destinations']))) {
            $airportDataset->setInternationalDestinations($internationalDestinations);
        }

        if (!is_null($year = $this->parseInt($csv['year']))) {
            $airportDataset->setYear($year);
        }

        return $airportDataset;
    }
}
