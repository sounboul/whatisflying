<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Factory\FirFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\FirFactory
 */
final class FirFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'icao_code' => 'LFBB',
        'name' => 'BORDEAUX',
    ];

    /**
     * @testdox Sets the flight information region ICAO code.
     */
    public function testSetIcaoCode(): void
    {
        $firFactory = new FirFactory();
        $fir = $firFactory->createFromCsv(self::$data);

        self::assertEquals('LFBB', $fir->getIcaoCode());
    }

    /**
     * @testdox Sets the flight information region name.
     */
    public function testSetName(): void
    {
        $firFactory = new FirFactory();
        $fir = $firFactory->createFromCsv(self::$data);

        self::assertEquals('BORDEAUX', $fir->getName());
    }
}
