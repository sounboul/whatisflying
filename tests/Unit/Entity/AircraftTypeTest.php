<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Aircraft;
use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use App\Entity\AircraftTypePicture;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\AircraftType
 */
final class AircraftTypeTest extends TestCase
{
    /**
     * @testdox Sets/gets the aircraft type absolute ceiling.
     */
    public function testAbsoluteCeiling(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setAbsoluteCeiling(43250);

        self::assertEquals(43250, $aircraftType->getAbsoluteCeiling());
    }

    /**
     * @testdox Sets/gets the aircraft that belongs to the aircraft type.
     */
    public function testAircraft(): void
    {
        $aircrafts = $this
            ->getMockBuilder(ArrayCollection::class)
            ->getMock();

        $aircraftType = new AircraftType();
        $aircraftType->setAircraft($aircrafts);

        self::assertEquals($aircrafts, $aircraftType->getAircraft());

        $firstAircraft = $this
            ->getMockBuilder(Aircraft::class)
            ->getMock();

        $secondAircraft = $this
            ->getMockBuilder(Aircraft::class)
            ->getMock();

        $aircraftType = new AircraftType();
        $aircraftType->addAircraft($firstAircraft);
        $aircraftType->addAircraft($secondAircraft);
        $aircraftType->addAircraft($secondAircraft);

        self::assertCount(2, $aircraftType->getAircraft());

        $aircraftType->removeAircraft($firstAircraft);

        self::assertCount(1, $aircraftType->getAircraft());
    }

    /**
     * @testdox Sets/gets the aircraft family to which the aircraft type belongs.
     */
    public function testAircraftFamily(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setAircraftFamily('L');

        self::assertEquals('L', $aircraftType->getAircraftFamily());
    }

    /**
     * @testdox Sets/gets the aircraft models that belongs to the aircraft type.
     */
    public function testAircraftModels(): void
    {
        $aircraftModels = $this
            ->getMockBuilder(ArrayCollection::class)
            ->getMock();

        $aircraftType = new AircraftType();
        $aircraftType->setAircraftModels($aircraftModels);

        self::assertEquals($aircraftModels, $aircraftType->getAircraftModels());

        $firstAircraftModel = $this
            ->getMockBuilder(AircraftModel::class)
            ->getMock();

        $secondAircraftModel = $this
            ->getMockBuilder(AircraftModel::class)
            ->getMock();

        $aircraftType = new AircraftType();
        $aircraftType->addAircraftModel($firstAircraftModel);
        $aircraftType->addAircraftModel($secondAircraftModel);
        $aircraftType->addAircraftModel($secondAircraftModel);

        self::assertCount(2, $aircraftType->getAircraftModels());

        $aircraftType->removeAircraftModel($firstAircraftModel);

        self::assertCount(1, $aircraftType->getAircraftModels());
    }

    /**
     * @testdox Sets/gets the aircraft type approach speed.
     */
    public function testApproachSpeed(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setApproachSpeed(137);

        self::assertEquals(137, $aircraftType->getApproachSpeed());
    }

    /**
     * @testdox Sets/gets the aircraft type all-up weight.
     */
    public function testAuw(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setAuw(107752);

        self::assertEquals(107752, $aircraftType->getAuw());
    }

    /**
     * @testdox Sets/gets the aircraft type climb rate.
     */
    public function testClimbRate(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setClimbRate(4000);

        self::assertEquals(4000, $aircraftType->getClimbRate());
    }

    /**
     * @testdox Sets/gets the aircraft type cruise speed.
     */
    public function testCruiseSpeed(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setCruiseSpeed(461);

        self::assertEquals(461, $aircraftType->getCruiseSpeed());
    }

    /**
     * @testdox Sets/gets the aircraft type description.
     */
    public function testDescription(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setDescription('L2J');

        self::assertEquals('L2J', $aircraftType->getDescription());
    }

    /**
     * @testdox Sets/gets the aircraft type engines count.
     */
    public function testEngineCount(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setEngineCount(2);

        self::assertEquals(2, $aircraftType->getEngineCount());
    }

    /**
     * @testdox Sets/gets the aircraft type engines type.
     */
    public function testEngineType(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setEngineType('J');

        self::assertEquals('J', $aircraftType->getEngineType());
    }

    /**
     * @testdox Sets/gets the aircraft type ferry range.
     */
    public function testFerryRange(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setFerryRange(5830);

        self::assertEquals(5830, $aircraftType->getFerryRange());
    }

    /**
     * @testdox Sets/gets the aircraft type fuel capacity.
     */
    public function testFuelCapacity(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setFuelCapacity(43490);

        self::assertEquals(43490, $aircraftType->getFuelCapacity());
    }

    /**
     * @testdox Sets/gets the aircraft type fuselage height.
     */
    public function testFuselageHeight(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setFuselageHeight(3.82);

        self::assertEquals(3.82, $aircraftType->getFuselageHeight());
    }

    /**
     * @testdox Sets/gets the aircraft type fuselage width.
     */
    public function testFuselageWidth(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setFuselageWidth(3.76);

        self::assertEquals(3.76, $aircraftType->getFuselageWidth());
    }

    /**
     * @testdox Sets/gets the aircraft type overall height.
     */
    public function testHeight(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setHeight(13.60);

        self::assertEquals(13.60, $aircraftType->getHeight());
    }

    /**
     * @testdox Sets/gets the aircraft type IATA code.
     */
    public function testIataCode(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setIataCode('752');

        self::assertEquals('752', $aircraftType->getIataCode());
    }

    /**
     * @testdox Sets/gets the aircraft type ICAO code.
     */
    public function testIcaoCode(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setIcaoCode('B752');

        self::assertEquals('B752', $aircraftType->getIcaoCode());
    }

    /**
     * @testdox Sets/gets the aircraft type overall length.
     */
    public function testLength(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setLength(47.30);

        self::assertEquals(47.30, $aircraftType->getLength());
    }

    /**
     * @testdox Sets/gets the aircraft type main rotor area.
     */
    public function testMainRotorArea(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setMainRotorArea(82.52);

        self::assertEquals(82.52, $aircraftType->getMainRotorArea());
    }

    /**
     * @testdox Sets/gets the aircraft type main rotor diameter.
     */
    public function testMainRotorDiameter(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setMainRotorDiameter(10.25);

        self::assertEquals(10.25, $aircraftType->getMainRotorDiameter());
    }

    /**
     * @testdox Sets/gets the aircraft type manufacturer.
     */
    public function testManufacturer(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setManufacturer('Boeing');

        self::assertEquals('Boeing', $aircraftType->getManufacturer());
    }

    /**
     * @testdox Sets/gets the aircraft type maximum speed.
     */
    public function testMaximumSpeed(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setMaximumSpeed(496);

        self::assertEquals(496, $aircraftType->getMaximumSpeed());
    }

    /**
     * @testdox Sets/gets the aircraft type maximum landing weight.
     */
    public function testMlw(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setMlw(90000);

        self::assertEquals(90000, $aircraftType->getMlw());
    }

    /**
     * @testdox Sets/gets the aircraft type maximum ramp weight.
     */
    public function testMrw(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setMrw(109315);

        self::assertEquals(109315, $aircraftType->getMrw());
    }

    /**
     * @testdox Sets/gets the aircraft type maximum takeoff weight.
     */
    public function testMtow(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setMtow(108862);

        self::assertEquals(108862, $aircraftType->getMtow());
    }

    /**
     * @testdox Sets/gets the aircraft type maximum zero-fuel weight.
     */
    public function testMzfw(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setMzfw(83500);

        self::assertEquals(83500, $aircraftType->getMzfw());
    }

    /**
     * @testdox Sets/gets the aircraft type name.
     */
    public function testName(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setName('757-200');

        self::assertEquals('757-200', $aircraftType->getName());
    }

    /**
     * @testdox Sets/gets the aircraft type never exceed speed.
     */
    public function testNeverExceedSpeed(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setNeverExceedSpeed(543);

        self::assertEquals(543, $aircraftType->getNeverExceedSpeed());
    }

    /**
     * @testdox Sets/gets the aircraft type operating empty weight.
     */
    public function testOew(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setOew(58440);

        self::assertEquals(58440, $aircraftType->getOew());
    }

    /**
     * @testdox Sets/gets the aircraft type operating range.
     */
    public function testOperatingRange(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setOperatingRange(3915);

        self::assertEquals(3915, $aircraftType->getOperatingRange());
    }

    /**
     * @testdox Sets/gets the aircraft type pictures.
     */
    public function testPictures(): void
    {
        $pictures = $this
            ->getMockBuilder(ArrayCollection::class)
            ->getMock();

        $aircraftType = new AircraftType();
        $aircraftType->setPictures($pictures);

        self::assertEquals($pictures, $aircraftType->getPictures());

        $firstPicture = $this
            ->getMockBuilder(AircraftTypePicture::class)
            ->getMock();

        $secondPicture = $this
            ->getMockBuilder(AircraftTypePicture::class)
            ->getMock();

        $aircraftType = new AircraftType();

        self::assertEquals(null, $aircraftType->getFirstPicture());

        $aircraftType->addPicture($firstPicture);
        $aircraftType->addPicture($secondPicture);
        $aircraftType->addPicture($secondPicture);

        self::assertEquals($firstPicture, $aircraftType->getFirstPicture());
        self::assertCount(2, $aircraftType->getPictures());

        $aircraftType->removePicture($secondPicture);

        self::assertCount(1, $aircraftType->getPictures());
    }

    /**
     * @testdox Sets/gets the aircraft type service ceiling.
     */
    public function testServiceCeiling(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setServiceCeiling(42000);

        self::assertEquals(42000, $aircraftType->getServiceCeiling());
    }

    /**
     * @testdox Sets/gets the aircraft type certificate URL.
     */
    public function testTypeCertificate(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setTypeCertificate(
            'https://www.easa.europa.eu/document-library/type-certificates/aircraft-cs-25-cs-22-cs-23-cs-vla-cs-lsa/easaima205'
        );

        self::assertEquals(
            'https://www.easa.europa.eu/document-library/type-certificates/aircraft-cs-25-cs-22-cs-23-cs-vla-cs-lsa/easaima205',
            $aircraftType->getTypeCertificate()
        );
    }

    /**
     * @testdox Sets/gets the aircraft type wing area.
     */
    public function testWingArea(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setWingArea(185.25);

        self::assertEquals(185.25, $aircraftType->getWingArea());
    }

    /**
     * @testdox Sets/gets the aircraft type wingspan.
     */
    public function testWingspan(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setWingspan(38.00);

        self::assertEquals(38.00, $aircraftType->getWingspan());
    }

    /**
     * @testdox Sets/gets the aircraft type ICAO wake turbulence category.
     */
    public function testWtc(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setWtc('M');

        self::assertEquals('M', $aircraftType->getWtc());
    }
}
