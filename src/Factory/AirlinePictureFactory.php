<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Airline;
use App\Entity\AirlinePicture;
use App\Traits\CsvParserTrait;
use Doctrine\ORM\EntityManagerInterface;

final class AirlinePictureFactory implements AirlinePictureFactoryInterface
{
    use CsvParserTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createFromCsv(array $csv): AirlinePicture
    {
        $airlinePicture = new AirlinePicture();

        if (!is_null($airline = $this->parseString($csv['airline']))) {
            $airline = $this->entityManager
                ->getRepository(Airline::class)
                ->findOneBy(['icaoCode' => $airline]);

            if (!is_null($airline)) {
                $airlinePicture->setAirline($airline);
            }
        }

        if (!is_null($authorName = $this->parseString($csv['author_name']))) {
            $airlinePicture->setAuthorName($authorName);
        }

        if (!is_null($authorProfile = $this->parseString($csv['author_profile']))) {
            $airlinePicture->setAuthorProfile($authorProfile);
        }

        if (!is_null($license = $this->parseString($csv['license']))) {
            $airlinePicture->setLicense($license);
        }

        if (!is_null($source = $this->parseString($csv['source']))) {
            $airlinePicture->setSource($source);
        }

        return $airlinePicture;
    }
}
