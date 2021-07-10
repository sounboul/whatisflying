<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AirportDataset;

interface AirportDatasetFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return AirportDataset
     */
    public function createFromCsv(array $csv): AirportDataset;
}
