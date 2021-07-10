<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Airline;

interface AirlineFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return Airline
     */
    public function createFromCsv(array $csv): Airline;
}
