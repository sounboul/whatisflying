<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AirportRunway;

interface AirportRunwayFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return AirportRunway
     */
    public function createFromCsv(array $csv): AirportRunway;
}
