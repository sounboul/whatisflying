<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\AircraftType;
use App\Entity\AircraftTypePicture;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\AircraftTypePicture
 */
final class AircraftTypePictureTest extends TestCase
{
    /**
     * @testdox Sets/gets the aircraft type to which the picture belongs.
     */
    public function testAircraftType(): void
    {
        $aircraftType = $this
            ->getMockBuilder(AircraftType::class)
            ->getMock();

        $aircraftTypePicture = new AircraftTypePicture();
        $aircraftTypePicture->setAircraftType($aircraftType);

        self::assertEquals($aircraftType, $aircraftTypePicture->getAircraftType());
    }
}
