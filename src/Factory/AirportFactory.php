<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Airport;
use App\Entity\Fir;
use App\Traits\CsvParserTrait;
use Doctrine\ORM\EntityManagerInterface;

final class AirportFactory implements AirportFactoryInterface
{
    use CsvParserTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createFromCsv(array $csv): Airport
    {
        $airport = new Airport();

        if (!is_null($active = $this->parseBool($csv['active']))) {
            $airport->setActive($active);
        }

        if (!is_null($continent = $this->parseString($csv['continent']))) {
            $airport->setContinent(strtoupper($continent));
        }

        if (!is_null($country = $this->parseString($csv['country']))) {
            $airport->setCountry(strtoupper($country));
        }

        if (!is_null($elevation = $this->parseInt($csv['elevation']))) {
            $airport->setElevation($elevation);
        }

        if (!is_null($fir = $this->parseString($csv['fir']))) {
            $fir = $this->entityManager
                ->getRepository(Fir::class)
                ->findOneBy(['icaoCode' => $fir]);

            $airport->setFir($fir);
        }

        if (!is_null($iataCode = $this->parseString($csv['iata_code']))) {
            $airport->setIataCode(strtoupper($iataCode));
        }

        if (!is_null($icaoCode = $this->parseString($csv['icao_code']))) {
            $airport->setIcaoCode(strtoupper($icaoCode));
        }

        if (!is_null($international = $this->parseBool($csv['international']))) {
            $airport->setInternational($international);
        }

        if (!is_null($latitude = $this->parseFloat($csv['latitude']))) {
            $airport->setLatitude(round($latitude, 5));
        }

        if (!is_null($longitude = $this->parseFloat($csv['longitude']))) {
            $airport->setLongitude(round($longitude, 5));
        }

        if (!is_null($name = $this->parseString($csv['name']))) {
            $airport->setName($name);
        }

        if (!is_null($type = $this->parseString($csv['type']))) {
            $airport->setType(strtolower($type));
        }

        return $airport;
    }
}
