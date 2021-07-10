<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AircraftType;

interface AircraftTypeFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return AircraftType
     */
    public function createFromCsv(array $csv): AircraftType;
}
