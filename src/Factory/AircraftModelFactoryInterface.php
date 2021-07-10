<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AircraftModel;

interface AircraftModelFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return AircraftModel
     */
    public function createFromCsv(array $csv): AircraftModel;
}
