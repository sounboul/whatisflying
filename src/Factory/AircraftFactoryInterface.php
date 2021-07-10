<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Aircraft;

interface AircraftFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return Aircraft
     */
    public function createFromCsv(array $csv): Aircraft;
}
