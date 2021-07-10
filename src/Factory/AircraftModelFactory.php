<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use App\Traits\CsvParserTrait;
use Doctrine\ORM\EntityManagerInterface;

final class AircraftModelFactory implements AircraftModelFactoryInterface
{
    use CsvParserTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createFromCsv(array $csv): AircraftModel
    {
        $aircraftModel = new AircraftModel();

        if (!is_null($aircraftType = $this->parseString($csv['aircraft_type']))) {
            $aircraftType = $this->entityManager
                ->getRepository(AircraftType::class)
                ->findOneBy(['icaoCode' => $aircraftType]);

            if (!is_null($aircraftType)) {
                $aircraftModel->setAircraftType($aircraftType);
            }
        }

        if (!is_null($certified = $this->parseString($csv['certified_at']))) {
            $certified = \DateTime::createFromFormat('Y-m-d', $certified);
            if ($certified instanceof \DateTime) {
                $aircraftModel->setCertified($certified);
            }
        }

        if (!is_null($engineManufacturer = $this->parseString($csv['engine_manufacturer']))) {
            $aircraftModel->setEngineManufacturer($engineManufacturer);
        }

        if (!is_null($engineModel = $this->parseString($csv['engine_model']))) {
            $aircraftModel->setEngineModel($engineModel);
        }

        if (!is_null($name = $this->parseString($csv['name']))) {
            $aircraftModel->setName($name);
        }

        return $aircraftModel;
    }
}
