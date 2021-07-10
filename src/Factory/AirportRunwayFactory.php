<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Airport;
use App\Entity\AirportRunway;
use App\Traits\CsvParserTrait;
use Doctrine\ORM\EntityManagerInterface;

final class AirportRunwayFactory implements AirportRunwayFactoryInterface
{
    use CsvParserTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createFromCsv(array $csv): AirportRunway
    {
        $airportRunway = new AirportRunway();

        if (!is_null($active = $this->parseBool($csv['active']))) {
            $airportRunway->setActive($active);
        }

        if (!is_null($airport = $this->parseString($csv['airport']))) {
            $airport = $this->entityManager
                ->getRepository(Airport::class)
                ->findOneBy(['icaoCode' => $airport]);

            if (!is_null($airport)) {
                $airportRunway->setAirport($airport);
            }
        }

        if (!is_null($heDisplacedThreshold = $this->parseInt($csv['he_displaced_threshold']))) {
            $airportRunway->setHEDisplacedThreshold($heDisplacedThreshold);
        }

        if (!is_null($heElevation = $this->parseInt($csv['he_elevation']))) {
            $airportRunway->setHEElevation($heElevation);
        }

        if (!is_null($heHeading = $this->parseFloat($csv['he_heading']))) {
            $airportRunway->setHEHeading(round($heHeading, 1));
        }

        if (!is_null($heLatitude = $this->parseFloat($csv['he_latitude']))) {
            $airportRunway->setHELatitude(round($heLatitude, 5));
        }

        if (!is_null($heLongitude = $this->parseFloat($csv['he_longitude']))) {
            $airportRunway->setHELongitude(round($heLongitude, 5));
        }

        if (!is_null($heName = $this->parseString($csv['he_name']))) {
            $airportRunway->setHEName(strtoupper($heName));
        }

        if (!is_null($leDisplacedThreshold = $this->parseInt($csv['le_displaced_threshold']))) {
            $airportRunway->setLEDisplacedThreshold($leDisplacedThreshold);
        }

        if (!is_null($leElevation = $this->parseInt($csv['le_elevation']))) {
            $airportRunway->setLEElevation($leElevation);
        }

        if (!is_null($leHeading = $this->parseFloat($csv['le_heading']))) {
            $airportRunway->setLEHeading(round($leHeading, 1));
        }

        if (!is_null($leLatitude = $this->parseFloat($csv['le_latitude']))) {
            $airportRunway->setLELatitude(round($leLatitude, 5));
        }

        if (!is_null($leLongitude = $this->parseFloat($csv['le_longitude']))) {
            $airportRunway->setLELongitude(round($leLongitude, 5));
        }

        if (!is_null($leName = $this->parseString($csv['le_name']))) {
            $airportRunway->setLEName(strtoupper($leName));
        }

        if (!is_null($length = $this->parseInt($csv['length']))) {
            $airportRunway->setLength($length);
        }

        if (!is_null($lighted = $this->parseBool($csv['lighted']))) {
            $airportRunway->setLighted($lighted);
        }

        if (!is_null($surface = $this->parseString($csv['surface']))) {
            $airportRunway->setSurface(strtoupper($surface));
        }

        if (!is_null($width = $this->parseInt($csv['width']))) {
            $airportRunway->setWidth($width);
        }

        return $airportRunway;
    }
}
