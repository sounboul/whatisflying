<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AircraftType;
use App\Traits\CsvParserTrait;

final class AircraftTypeFactory implements AircraftTypeFactoryInterface
{
    use CsvParserTrait;

    public function createFromCsv(array $csv): AircraftType
    {
        $aircraftType = new AircraftType();

        if (!is_null($absoluteCeiling = $this->parseInt($csv['absolute_ceiling']))) {
            $aircraftType->setAbsoluteCeiling($absoluteCeiling);
        }

        if (!is_null($approachSpeed = $this->parseInt($csv['approach_speed']))) {
            $aircraftType->setApproachSpeed($approachSpeed);
        }

        if (!is_null($auw = $this->parseInt($csv['auw']))) {
            $aircraftType->setAuw($auw);
        }

        if (!is_null($climbRate = $this->parseInt($csv['climb_rate']))) {
            $aircraftType->setClimbRate($climbRate);
        }

        if (!is_null($cruiseSpeed = $this->parseInt($csv['cruise_speed']))) {
            $aircraftType->setCruiseSpeed($cruiseSpeed);
        }

        if (!is_null($description = $this->parseString($csv['description']))) {
            $aircraftType->setDescription(strtoupper($description));

            if (preg_match('/^([A-Z])([0-9]+)([A-Z])$/', strtoupper($description), $matches)) {
                $aircraftType
                    ->setAircraftFamily($matches[1])
                    ->setEngineCount(intval($matches[2]))
                    ->setEngineType($matches[3]);
            }
        }

        if (!is_null($ferryRange = $this->parseInt($csv['ferry_range']))) {
            $aircraftType->setFerryRange($ferryRange);
        }

        if (!is_null($fuelCapacity = $this->parseInt($csv['fuel_capacity']))) {
            $aircraftType->setFuelCapacity($fuelCapacity);
        }

        if (!is_null($fuselageHeight = $this->parseFloat($csv['fuselage_height']))) {
            $aircraftType->setFuselageHeight(round($fuselageHeight, 2));
        }

        if (!is_null($fuselageWidth = $this->parseFloat($csv['fuselage_width']))) {
            $aircraftType->setFuselageWidth(round($fuselageWidth, 2));
        }

        if (!is_null($height = $this->parseFloat($csv['height']))) {
            $aircraftType->setHeight(round($height, 2));
        }

        if (!is_null($iataCode = $this->parseString($csv['iata_code']))) {
            $aircraftType->setIataCode(strtoupper($iataCode));
        }

        if (!is_null($icaoCode = $this->parseString($csv['icao_code']))) {
            $aircraftType->setIcaoCode(strtoupper($icaoCode));
        }

        if (!is_null($length = $this->parseFloat($csv['length']))) {
            $aircraftType->setLength(round($length, 2));
        }

        if (!is_null($mainRotorArea = $this->parseFloat($csv['main_rotor_area']))) {
            $aircraftType->setMainRotorArea(round($mainRotorArea, 2));
        }

        if (!is_null($mainRotorDiameter = $this->parseFloat($csv['main_rotor_diameter']))) {
            $aircraftType->setMainRotorDiameter(round($mainRotorDiameter, 2));
        }

        if (!is_null($manufacturer = $this->parseString($csv['manufacturer']))) {
            $aircraftType->setManufacturer($manufacturer);
        }

        if (!is_null($mlw = $this->parseInt($csv['mlw']))) {
            $aircraftType->setMlw($mlw);
        }

        if (!is_null($mrw = $this->parseInt($csv['mrw']))) {
            $aircraftType->setMrw($mrw);
        }

        if (!is_null($maximumSpeed = $this->parseInt($csv['maximum_speed']))) {
            $aircraftType->setMaximumSpeed($maximumSpeed);
        }

        if (!is_null($mtow = $this->parseInt($csv['mtow']))) {
            $aircraftType->setMtow($mtow);
        }

        if (!is_null($mzfw = $this->parseInt($csv['mzfw']))) {
            $aircraftType->setMzfw($mzfw);
        }

        if (!is_null($name = $this->parseString($csv['name']))) {
            $aircraftType->setName($name);
        }

        if (!is_null($neverExceedSpeed = $this->parseInt($csv['never_exceed_speed']))) {
            $aircraftType->setNeverExceedSpeed($neverExceedSpeed);
        }

        if (!is_null($oew = $this->parseInt($csv['oew']))) {
            $aircraftType->setOew($oew);
        }

        if (!is_null($operatingRange = $this->parseInt($csv['operating_range']))) {
            $aircraftType->setOperatingRange($operatingRange);
        }

        if (!is_null($serviceCeiling = $this->parseInt($csv['service_ceiling']))) {
            $aircraftType->setServiceCeiling($serviceCeiling);
        }

        if (!is_null($typeCertificate = $this->parseString($csv['type_certificate']))) {
            $aircraftType->setTypeCertificate($typeCertificate);
        }

        if (!is_null($wingArea = $this->parseFloat($csv['wing_area']))) {
            $aircraftType->setWingArea(round($wingArea, 2));
        }

        if (!is_null($wingspan = $this->parseFloat($csv['wingspan']))) {
            $aircraftType->setWingspan(round($wingspan, 2));
        }

        if (!is_null($wtc = $this->parseString($csv['wtc']))) {
            $aircraftType->setWtc(strtoupper($wtc));
        }

        return $aircraftType;
    }
}
