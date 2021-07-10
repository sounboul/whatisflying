<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Airport;
use App\Entity\Fix;
use App\Traits\CsvParserTrait;
use Doctrine\ORM\EntityManagerInterface;

final class FixFactory implements FixFactoryInterface
{
    use CsvParserTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createFromCsv(array $csv): Fix
    {
        $fix = new Fix();

        if (!is_null($airport = $this->parseString($csv['airport']))) {
            $airport = $this->entityManager
                ->getRepository(Airport::class)
                ->findOneBy(['icaoCode' => $airport]);

            $fix->setAirport($airport);
        }

        if (!is_null($identifier = $this->parseString($csv['identifier']))) {
            $fix->setIdentifier(strtoupper($identifier));
        }

        if (!is_null($latitude = $this->parseFloat($csv['latitude']))) {
            $fix->setLatitude(round($latitude, 5));
        }

        if (!is_null($longitude = $this->parseFloat($csv['longitude']))) {
            $fix->setLongitude(round($longitude, 5));
        }

        if (!is_null($region = $this->parseString($csv['region']))) {
            $fix->setRegion($region);
        }

        if (!is_null($slug = $this->parseString($csv['slug']))) {
            $fix->setSlug($slug);
        }

        if (!is_null($usage = $this->parseString($csv['usage']))) {
            $fix->setUsage(strtoupper($usage));
        }

        return $fix;
    }
}
