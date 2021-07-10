<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Airline;
use App\Entity\AirlineLogo;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\AirlineLogo
 */
final class AirlineLogoTest extends TestCase
{
    /**
     * @testdox Sets/gets the airline to which the logo belongs.
     */
    public function testAirline(): void
    {
        $airline = $this
            ->getMockBuilder(Airline::class)
            ->getMock();

        $airlineLogo = new AirlineLogo();
        $airlineLogo->setAirline($airline);

        self::assertEquals($airline, $airlineLogo->getAirline());
    }
}
