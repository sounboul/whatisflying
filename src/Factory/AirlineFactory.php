<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Airline;
use App\Traits\CsvParserTrait;

final class AirlineFactory implements AirlineFactoryInterface
{
    use CsvParserTrait;

    public function createFromCsv(array $csv): Airline
    {
        $airline = new Airline();

        if (!is_null($accidentsLast5Years = $this->parseInt($csv['accidents_last_5_years']))) {
            $airline->setAccidentsLast5Years($accidentsLast5Years);
        }

        if (!is_null($active = $this->parseBool($csv['active']))) {
            $airline->setActive($active);
        }

        if (!is_null($aircraftOver25Years = $this->parseInt($csv['aircraft_over_25_years']))) {
            $airline->setAircraftOver25Years($aircraftOver25Years);
        }

        if (!is_null($annualDomesticFlights = $this->parseInt($csv['annual_domestic_flights']))) {
            $airline->setAnnualDomesticFlights($annualDomesticFlights);
        }

        if (!is_null($annualInternationalFlights = $this->parseInt($csv['annual_international_flights']))) {
            $airline->setAnnualInternationalFlights($annualInternationalFlights);
        }

        if (!is_null($averageFleetAge = $this->parseFloat($csv['average_fleet_age']))) {
            $airline->setAverageFleetAge($averageFleetAge);
        }

        if (!is_null($callsign = $this->parseString($csv['callsign']))) {
            $airline->setCallsign(strtoupper($callsign));
        }

        if (!is_null($country = $this->parseString($csv['country']))) {
            $airline->setCountry(strtoupper($country));
        }

        if (!is_null($destinations = $this->parseInt($csv['destinations']))) {
            $airline->setDestinations($destinations);
        }

        if (!is_null($fatalAccidentsLast5Years = $this->parseInt($csv['fatal_accidents_last_5_years']))) {
            $airline->setFatalAccidentsLast5Years($fatalAccidentsLast5Years);
        }

        if (!is_null($iataCode = $this->parseString($csv['iata_code']))) {
            $airline->setIataCode(strtoupper($iataCode));
        }

        if (!is_null($iataMember = $this->parseBool($csv['iata_member']))) {
            $airline->setIataMember($iataMember);
        }

        if (!is_null($icaoCode = $this->parseString($csv['icao_code']))) {
            $airline->setIcaoCode(strtoupper($icaoCode));
        }

        if (!is_null($international = $this->parseBool($csv['international']))) {
            $airline->setInternational($international);
        }

        if (!is_null($iosaCertified = $this->parseBool($csv['iosa_certified']))) {
            $airline->setIosaCertified($iosaCertified);
        }

        if (!is_null($name = $this->parseString($csv['name']))) {
            $airline->setName($name);
        }

        return $airline;
    }
}
