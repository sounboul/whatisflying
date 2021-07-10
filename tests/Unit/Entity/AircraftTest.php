<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Aircraft;
use App\Entity\AircraftPicture;
use App\Entity\AircraftType;
use App\Entity\Airline;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Aircraft
 */
final class AircraftTest extends TestCase
{
    /**
     * @testdox Sets/gets the aircraft family to which the aircraft belongs.
     */
    public function testAircraftFamily(): void
    {
        $aircraft = new Aircraft();
        $aircraft->setAircraftFamily('L');

        self::assertEquals('L', $aircraft->getAircraftFamily());
    }

    /**
     * @testdox Sets/gets the aircraft type to which the aircraft belongs.
     */
    public function testAircraftType(): void
    {
        $aircraftType = $this
            ->getMockBuilder(AircraftType::class)
            ->getMock();

        $aircraft = new Aircraft();
        $aircraft->setAircraftType($aircraftType);

        self::assertEquals($aircraftType, $aircraft->getAircraftType());
    }

    /**
     * @testdox Sets/gets the aircraft description.
     */
    public function testDescription(): void
    {
        $aircraft = new Aircraft();
        $aircraft->setDescription('L2J');

        self::assertEquals('L2J', $aircraft->getDescription());
    }

    /**
     * @testdox Sets/gets the aircraft engines count.
     */
    public function testEngineCount(): void
    {
        $aircraft = new Aircraft();
        $aircraft->setEngineCount(2);

        self::assertEquals(2, $aircraft->getEngineCount());
    }

    /**
     * @testdox Sets/gets the aircraft engines type.
     */
    public function testEngineType(): void
    {
        $aircraft = new Aircraft();
        $aircraft->setEngineType('J');

        self::assertEquals('J', $aircraft->getEngineType());
    }

    /**
     * @testdox Sets/gets the aircraft ICAO 24-bit address.
     */
    public function testIcao24bitAddress(): void
    {
        $aircraft = new Aircraft();
        $aircraft->setIcao24bitAddress('38f4d7');

        self::assertEquals('38f4d7', $aircraft->getIcao24bitAddress());
    }

    /**
     * @testdox Sets/gets the aircraft manufacturing date.
     */
    public function testManufactured(): void
    {
        $manufactured = $this
            ->getMockBuilder(\DateTime::class)
            ->getMock();

        $aircraft = new Aircraft();
        $aircraft->setManufactured($manufactured);

        self::assertEquals($manufactured, $aircraft->getManufactured());
    }

    /**
     * @testdox Sets/gets the aircraft manufacturer.
     */
    public function testManufacturer(): void
    {
        $aircraft = new Aircraft();
        $aircraft->setManufacturer('Airbus');

        self::assertEquals('Airbus', $aircraft->getManufacturer());
    }

    /**
     * @testdox Sets/gets the aircraft model.
     */
    public function testModel(): void
    {
        $aircraft = new Aircraft();
        $aircraft->setModel('A320-271N');

        self::assertEquals('A320-271N', $aircraft->getModel());
    }

    /**
     * @testdox Sets/gets the aircraft operator.
     */
    public function testOperator(): void
    {
        $operator = $this
            ->getMockBuilder(Airline::class)
            ->getMock();

        $aircraft = new Aircraft();
        $aircraft->setOperator($operator);

        self::assertEquals($operator, $aircraft->getOperator());
    }

    /**
     * @testdox Sets/gets the aircraft pictures.
     */
    public function testPictures(): void
    {
        $pictures = $this
            ->getMockBuilder(ArrayCollection::class)
            ->getMock();

        $aircraft = new Aircraft();
        $aircraft->setPictures($pictures);

        self::assertEquals($pictures, $aircraft->getPictures());

        $firstPicture = $this
            ->getMockBuilder(AircraftPicture::class)
            ->getMock();

        $secondPicture = $this
            ->getMockBuilder(AircraftPicture::class)
            ->getMock();

        $aircraft = new Aircraft();

        self::assertEquals(null, $aircraft->getFirstPicture());
        
        $aircraft->addPicture($firstPicture);
        $aircraft->addPicture($secondPicture);
        $aircraft->addPicture($secondPicture);

        self::assertEquals($firstPicture, $aircraft->getFirstPicture());
        self::assertCount(2, $aircraft->getPictures());

        $aircraft->removePicture($secondPicture);

        self::assertCount(1, $aircraft->getPictures());
    }

    /**
     * @testdox Sets/gets the aircraft registration date.
     */
    public function testRegistered(): void
    {
        $registered = $this
            ->getMockBuilder(\DateTime::class)
            ->getMock();

        $aircraft = new Aircraft();
        $aircraft->setRegistered($registered);

        self::assertEquals($registered, $aircraft->getRegistered());
    }

    /**
     * @testdox Sets/gets the aircraft registration expiration date.
     */
    public function testRegisteredUntil(): void
    {
        $registeredUntil = $this
            ->getMockBuilder(\DateTime::class)
            ->getMock();

        $aircraft = new Aircraft();
        $aircraft->setRegisteredUntil($registeredUntil);

        self::assertEquals($registeredUntil, $aircraft->getRegisteredUntil());
    }

    /**
     * @testdox Sets/gets the aircraft registration.
     */
    public function testRegistration(): void
    {
        $aircraft = new Aircraft();
        $aircraft->setRegistration('F-AILD');

        self::assertEquals('F-AILD', $aircraft->getRegistration());
    }

    /**
     * @testdox Sets/gets the aircraft registration country.
     */
    public function testRegistrationCountry(): void
    {
        $aircraft = new Aircraft();
        $aircraft->setRegistrationCountry('FR');

        self::assertEquals('FR', $aircraft->getRegistrationCountry());
    }

    /**
     * @testdox Sets/gets the aircraft manufacturer serial number.
     */
    public function testSerialNumber(): void
    {
        $aircraft = new Aircraft();
        $aircraft->setSerialNumber('4781');

        self::assertEquals('4781', $aircraft->getSerialNumber());
    }
}
