<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Airport;

interface AirportFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return Airport
     */
    public function createFromCsv(array $csv): Airport;
}
