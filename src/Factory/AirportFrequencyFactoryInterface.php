<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AirportFrequency;

interface AirportFrequencyFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return AirportFrequency
     */
    public function createFromCsv(array $csv): AirportFrequency;
}
