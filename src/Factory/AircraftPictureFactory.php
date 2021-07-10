<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Aircraft;
use App\Entity\AircraftPicture;
use App\Traits\CsvParserTrait;
use Doctrine\ORM\EntityManagerInterface;

final class AircraftPictureFactory implements AircraftPictureFactoryInterface
{
    use CsvParserTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createFromCsv(array $csv): AircraftPicture
    {
        $aircraftPicture = new AircraftPicture();

        if (!is_null($aircraft = $this->parseString($csv['aircraft']))) {
            $aircraft = $this->entityManager
                ->getRepository(Aircraft::class)
                ->findOneBy(['icao24bitAddress' => $aircraft]);

            if (!is_null($aircraft)) {
                $aircraftPicture->setAircraft($aircraft);
            }
        }

        if (!is_null($authorName = $this->parseString($csv['author_name']))) {
            $aircraftPicture->setAuthorName($authorName);
        }

        if (!is_null($authorProfile = $this->parseString($csv['author_profile']))) {
            $aircraftPicture->setAuthorProfile($authorProfile);
        }

        if (!is_null($license = $this->parseString($csv['license']))) {
            $aircraftPicture->setLicense($license);
        }

        if (!is_null($source = $this->parseString($csv['source']))) {
            $aircraftPicture->setSource($source);
        }

        return $aircraftPicture;
    }
}
