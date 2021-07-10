<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Aircraft;
use App\Entity\AircraftPicture;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\AircraftPicture
 */
final class AircraftPictureTest extends TestCase
{
    /**
     * @testdox Sets/gets the aircraft to which the picture belongs.
     */
    public function testAircraft(): void
    {
        $aircraft = $this
            ->getMockBuilder(Aircraft::class)
            ->getMock();

        $aircraftPicture = new AircraftPicture();
        $aircraftPicture->setAircraft($aircraft);

        self::assertEquals($aircraft, $aircraftPicture->getAircraft());
    }
}
