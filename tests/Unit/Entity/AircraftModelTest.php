<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\AircraftModel
 */
final class AircraftModelTest extends TestCase
{
    /**
     * @testdox Sets/gets the aircraft type to which the aircraft model belongs.
     */
    public function testAircraftType(): void
    {
        $aircraftType = $this
            ->getMockBuilder(AircraftType::class)
            ->getMock();

        $aircraftModel = new AircraftModel();
        $aircraftModel->setAircraftType($aircraftType);

        self::assertEquals($aircraftType, $aircraftModel->getAircraftType());
    }

    /**
     * @testdox Sets/gets the aircraft model certification date.
     */
    public function testCertified(): void
    {
        $certified = $this
            ->getMockBuilder(\DateTime::class)
            ->getMock();

        $aircraftModel = new AircraftModel();
        $aircraftModel->setCertified($certified);

        self::assertEquals($certified, $aircraftModel->getCertified());
    }

    /**
     * @testdox Sets/gets the aircraft model engines manufacturer.
     */
    public function testEngineManufacturer(): void
    {
        $aircraftModel = new AircraftModel();
        $aircraftModel->setEngineManufacturer('Pratt & Whitney');

        self::assertEquals('Pratt & Whitney', $aircraftModel->getEngineManufacturer());
    }

    /**
     * @testdox Sets/gets the aircraft model engines model.
     */
    public function testEngineModel(): void
    {
        $aircraftModel = new AircraftModel();
        $aircraftModel->setEngineModel('PW1524G');

        self::assertEquals('PW1524G', $aircraftModel->getEngineModel());
    }

    /**
     * @testdox Sets/gets the aircraft model name.
     */
    public function testName(): void
    {
        $aircraftModel = new AircraftModel();
        $aircraftModel->setName('A220-300');

        self::assertEquals('A220-300', $aircraftModel->getName());
    }
}
