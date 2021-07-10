<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AircraftType;
use App\Entity\AircraftTypePicture;
use App\Traits\CsvParserTrait;
use Doctrine\ORM\EntityManagerInterface;

final class AircraftTypePictureFactory implements AircraftTypePictureFactoryInterface
{
    use CsvParserTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createFromCsv(array $csv): AircraftTypePicture
    {
        $aircraftTypePicture = new AircraftTypePicture();

        if (!is_null($aircraftType = $this->parseString($csv['aircraft_type']))) {
            $aircraftType = $this->entityManager
                ->getRepository(AircraftType::class)
                ->findOneBy(['icaoCode' => $aircraftType]);

            if (!is_null($aircraftType)) {
                $aircraftTypePicture->setAircraftType($aircraftType);
            }
        }

        if (!is_null($authorName = $this->parseString($csv['author_name']))) {
            $aircraftTypePicture->setAuthorName($authorName);
        }

        if (!is_null($authorProfile = $this->parseString($csv['author_profile']))) {
            $aircraftTypePicture->setAuthorProfile($authorProfile);
        }

        if (!is_null($license = $this->parseString($csv['license']))) {
            $aircraftTypePicture->setLicense($license);
        }

        if (!is_null($source = $this->parseString($csv['source']))) {
            $aircraftTypePicture->setSource($source);
        }

        return $aircraftTypePicture;
    }
}
