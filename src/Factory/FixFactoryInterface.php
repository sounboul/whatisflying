<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Fix;

interface FixFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return Fix
     */
    public function createFromCsv(array $csv): Fix;
}
