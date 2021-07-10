<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Fir;

interface FirFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return Fir
     */
    public function createFromCsv(array $csv): Fir;
}
