<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Fir;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Fir
 */
final class FirTest extends TestCase
{
    /**
     * @testdox Sets/gets the flight information region ICAO code.
     */
    public function testIcaoCode(): void
    {
        $fir = new Fir();
        $fir->setIcaoCode('LFBB');

        self::assertEquals('LFBB', $fir->getIcaoCode());
    }

    /**
     * @testdox Sets/gets the flight information region name.
     */
    public function testName(): void
    {
        $fir = new Fir();
        $fir->setName('BORDEAUX');

        self::assertEquals('BORDEAUX', $fir->getName());
    }
}
