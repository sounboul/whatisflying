<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Navaid;

interface NavaidFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return Navaid
     */
    public function createFromCsv(array $csv): Navaid;
}
