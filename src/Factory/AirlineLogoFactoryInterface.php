<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AirlineLogo;

interface AirlineLogoFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return AirlineLogo
     */
    public function createFromCsv(array $csv): AirlineLogo;
}
