<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Fir;
use App\Traits\CsvParserTrait;

final class FirFactory implements FirFactoryInterface
{
    use CsvParserTrait;

    public function createFromCsv(array $csv): Fir
    {
        $fir = new Fir();

        if (!is_null($icaoCode = $this->parseString($csv['icao_code']))) {
            $fir->setIcaoCode(strtoupper($icaoCode));
        }

        if (!is_null($name = $this->parseString($csv['name']))) {
            $fir->setName(strtoupper($name));
        }

        return $fir;
    }
}
