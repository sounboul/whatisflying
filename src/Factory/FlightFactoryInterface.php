<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Flight;

interface FlightFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return Flight
     */
    public function createFromCsv(array $csv): Flight;
}
