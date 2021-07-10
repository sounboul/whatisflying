<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Airline;
use App\Entity\AirlinePicture;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\AirlinePicture
 */
final class AirlinePictureTest extends TestCase
{
    /**
     * @testdox Sets/gets the airline to which the picture belongs.
     */
    public function testAirline(): void
    {
        $airline = $this
            ->getMockBuilder(Airline::class)
            ->getMock();

        $airlinePicture = new AirlinePicture();
        $airlinePicture->setAirline($airline);

        self::assertEquals($airline, $airlinePicture->getAirline());
    }
}
