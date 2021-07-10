<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Airline;
use App\Entity\AirlineLogo;
use App\Traits\CsvParserTrait;
use Doctrine\ORM\EntityManagerInterface;

final class AirlineLogoFactory implements AirlineLogoFactoryInterface
{
    use CsvParserTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createFromCsv(array $csv): AirlineLogo
    {
        $airlineLogo = new AirlineLogo();

        if (!is_null($airline = $this->parseString($csv['airline']))) {
            $airline = $this->entityManager
                ->getRepository(Airline::class)
                ->findOneBy(['icaoCode' => $airline]);

            if (!is_null($airline)) {
                $airlineLogo->setAirline($airline);
            }
        }

        return $airlineLogo;
    }
}
