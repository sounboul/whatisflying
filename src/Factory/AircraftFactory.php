<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Aircraft;
use App\Entity\AircraftType;
use App\Entity\Airline;
use App\Traits\CsvParserTrait;
use App\Util\Icao24bitAddress;
use Doctrine\ORM\EntityManagerInterface;

final class AircraftFactory implements AircraftFactoryInterface
{
    use CsvParserTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createFromCsv(array $csv): Aircraft
    {
        $aircraft = new Aircraft();

        if (!is_null($aircraftType = $this->parseString($csv['aircraft_type']))) {
            $aircraftType = $this->entityManager
                ->getRepository(AircraftType::class)
                ->findOneBy(['icaoCode' => $aircraftType]);

            $aircraft->setAircraftType($aircraftType);
        }

        if (!is_null($description = $this->parseString($csv['description']))) {
            $aircraft->setDescription(strtoupper($description));

            if (preg_match('/^([A-Z])([0-9]+)([A-Z])$/', strtoupper($description), $matches)) {
                $aircraft
                    ->setAircraftFamily($matches[1])
                    ->setEngineCount(intval($matches[2]))
                    ->setEngineType($matches[3]);
            }
        }

        if (!is_null($icao24bitAddress = $this->parseString($csv['icao_24bit_address']))) {
            $aircraft->setIcao24bitAddress(strtolower($icao24bitAddress));

            if (!is_null($registrationCountry = Icao24bitAddress::getRegistrationCountry($icao24bitAddress))) {
                $aircraft->setRegistrationCountry($registrationCountry);
            }
        }

        if (!is_null($manufactured = $this->parseString($csv['manufactured_at']))) {
            $manufactured = \DateTime::createFromFormat('Y-m-d', $manufactured);
            if ($manufactured instanceof \DateTime) {
                $aircraft->setManufactured($manufactured);
            }
        }

        if (!is_null($manufacturer = $this->parseString($csv['manufacturer']))) {
            $aircraft->setManufacturer($manufacturer);
        }

        if (!is_null($model = $this->parseString($csv['model']))) {
            $aircraft->setModel($model);
        }

        if (!is_null($operator = $this->parseString($csv['operator']))) {
            $operator = $this->entityManager->getRepository(Airline::class)
                                            ->findOneBy(['icaoCode' => $operator]);

            $aircraft->setOperator($operator);
        }

        if (!is_null($registered = $this->parseString($csv['registered_at']))) {
            $registered = \DateTime::createFromFormat('Y-m-d', $registered);
            if ($registered instanceof \DateTime) {
                $aircraft->setRegistered($registered);
            }
        }

        if (!is_null($registeredUntil = $this->parseString($csv['registered_until']))) {
            $registeredUntil = \DateTime::createFromFormat('Y-m-d', $registeredUntil);
            if ($registeredUntil instanceof \DateTime) {
                $aircraft->setRegisteredUntil($registeredUntil);
            }
        }

        if (!is_null($registration = $this->parseString($csv['registration']))) {
            $aircraft->setRegistration(strtoupper($registration));
        }

        if (!is_null($serialNumber = $this->parseString($csv['serial_number']))) {
            $aircraft->setSerialNumber($serialNumber);
        }

        return $aircraft;
    }
}
