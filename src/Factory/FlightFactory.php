<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Airline;
use App\Entity\Airport;
use App\Entity\Flight;
use App\Traits\CsvParserTrait;
use Doctrine\ORM\EntityManagerInterface;

final class FlightFactory implements FlightFactoryInterface
{
    use CsvParserTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createFromCsv(array $csv): Flight
    {
        $flight = new Flight();

        if (!is_null($airline = $this->parseString($csv['airline']))) {
            $airline = $this->entityManager
                ->getRepository(Airline::class)
                ->findOneBy(['icaoCode' => $airline]);

            if (!is_null($airline)) {
                $flight->setAirline($airline);
            }
        }

        if (!is_null($arrivalAirport = $this->parseString($csv['arrival_airport']))) {
            $arrivalAirport = $this->entityManager
                ->getRepository(Airport::class)
                ->findOneBy(['icaoCode' => $arrivalAirport]);

            if (!is_null($arrivalAirport)) {
                $flight->setArrivalAirport($arrivalAirport);
            }
        }

        if (!is_null($departureAirport = $this->parseString($csv['departure_airport']))) {
            $departureAirport = $this->entityManager
                ->getRepository(Airport::class)
                ->findOneBy(['icaoCode' => $departureAirport]);

            if (!is_null($departureAirport)) {
                $flight->setDepartureAirport($departureAirport);
            }
        }

        if (!is_null($flightNumber = $this->parseString($csv['flight_number']))) {
            $flight->setFlightNumber(strtoupper($flightNumber));
        }

        if (!is_null($layoverAirports = $this->parseArray($csv['layover_airports']))) {
            foreach ($layoverAirports as $layoverAirport) {
                $layoverAirport = $this->entityManager
                    ->getRepository(Airport::class)
                    ->findOneBy(['icaoCode' => $layoverAirport]);

                if (!is_null($layoverAirport)) {
                    $flight->addLayoverAirport($layoverAirport);
                }
            }
        }

        return $flight;
    }
}
