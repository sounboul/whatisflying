<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Factory\AircraftTypeFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\AircraftTypeFactory
 */
final class AircraftTypeFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'absolute_ceiling' => '43250',
        'approach_speed' => '137',
        'auw' => '108862',
        'climb_rate' => '4000',
        'cruise_speed' => '461',
        'description' => 'L2J',
        'ferry_range' => '5830',
        'fuel_capacity' => '43490',
        'fuselage_height' => '3.82',
        'fuselage_width' => '3.76',
        'height' => '13.60',
        'iata_code' => '752',
        'icao_code' => 'B752',
        'length' => '47.30',
        'main_rotor_area' => '82.52',
        'main_rotor_diameter' => '10.25',
        'manufacturer' => 'Boeing',
        'maximum_speed' => '496',
        'mlw' => '90000',
        'mrw' => '109315',
        'mtow' => '108862',
        'mzfw' => '83500',
        'name' => '757-200',
        'never_exceed_speed' => '543',
        'oew' => '58440',
        'operating_range' => '3915',
        'service_ceiling' => '42000',
        'type_certificate' => 'https://www.easa.europa.eu/document-library/type-certificates/aircraft-cs-25-cs-22-cs-23-cs-vla-cs-lsa/easaima205',
        'wing_area' => '185.25',
        'wingspan' => '38.00',
        'wtc' => 'M',
    ];

    /**
     * @testdox Sets the aircraft type absolute ceiling.
     */
    public function testSetAbsoluteCeiling(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(43250, $aircraftType->getAbsoluteCeiling());
    }

    /**
     * @testdox Sets the aircraft family to which the aircraft type belongs.
     */
    public function testSetAircraftFamily(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals('L', $aircraftType->getAircraftFamily());
    }

    /**
     * @testdox Sets the aircraft type approach speed.
     */
    public function testSetApproachSpeed(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(137, $aircraftType->getApproachSpeed());
    }

    /**
     * @testdox Sets the aircraft type all-up weight.
     */
    public function testSetAuw(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(108862, $aircraftType->getAuw());
    }

    /**
     * @testdox Sets the aircraft type climb rate.
     */
    public function testSetClimbRate(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(4000, $aircraftType->getClimbRate());
    }

    /**
     * @testdox Sets the aircraft type cruise speed.
     */
    public function testSetCruiseSpeed(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(461, $aircraftType->getCruiseSpeed());
    }

    /**
     * @testdox Sets the aircraft type description.
     */
    public function testSetDescription(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals('L2J', $aircraftType->getDescription());
    }

    /**
     * @testdox Sets the aircraft type engines count.
     */
    public function testSetEngineCount(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(2, $aircraftType->getEngineCount());
    }

    /**
     * @testdox Sets the aircraft type engines type.
     */
    public function testSetEngineType(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals('J', $aircraftType->getEngineType());
    }

    /**
     * @testdox Sets the aircraft type ferry range.
     */
    public function testSetFerryRange(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(5830, $aircraftType->getFerryRange());
    }

    /**
     * @testdox Sets the aircraft type fuel capacity.
     */
    public function testSetFuelCapacity(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(43490, $aircraftType->getFuelCapacity());
    }

    /**
     * @testdox Sets the aircraft type fuselage height.
     */
    public function testSetFuselageHeight(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(3.82, $aircraftType->getFuselageHeight());
    }

    /**
     * @testdox Sets the aircraft type fuselage width.
     */
    public function testSetFuselageWidth(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(3.76, $aircraftType->getFuselageWidth());
    }

    /**
     * @testdox Sets the aircraft type overall height.
     */
    public function testSetHeight(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(13.6, $aircraftType->getHeight());
    }

    /**
     * @testdox Sets the aircraft type IATA code.
     */
    public function testSetIataCode(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals('752', $aircraftType->getIataCode());
    }

    /**
     * @testdox Sets the aircraft type ICAO code.
     */
    public function testSetIcaoCode(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals('B752', $aircraftType->getIcaoCode());
    }

    /**
     * @testdox Sets the aircraft type overall length.
     */
    public function testSetLength(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(47.3, $aircraftType->getLength());
    }

    /**
     * @testdox Sets the aircraft type main rotor area.
     */
    public function testSetMainRotorArea(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(82.52, $aircraftType->getMainRotorArea());
    }

    /**
     * @testdox Sets the aircraft type main rotor diameter.
     */
    public function testSetMainRotorDiameter(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(10.25, $aircraftType->getMainRotorDiameter());
    }

    /**
     * @testdox Sets the aircraft type manufacturer.
     */
    public function testSetManufacturer(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals('Boeing', $aircraftType->getManufacturer());
    }

    /**
     * @testdox Sets the aircraft type maximum speed.
     */
    public function testSetMaximumSpeed(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(496, $aircraftType->getMaximumSpeed());
    }

    /**
     * @testdox Sets the aircraft type maximum landing weight.
     */
    public function testSetMlw(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(90000, $aircraftType->getMlw());
    }

    /**
     * @testdox Sets the aircraft type maximum ramp weight.
     */
    public function testSetMrw(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(109315, $aircraftType->getMrw());
    }

    /**
     * @testdox Sets the aircraft type maximum takeoff weight.
     */
    public function testSetMtow(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(108862, $aircraftType->getMtow());
    }

    /**
     * @testdox Sets the aircraft type maximum zero-fuel weight.
     */
    public function testSetMzfw(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(83500, $aircraftType->getMzfw());
    }

    /**
     * @testdox Sets the aircraft type name.
     */
    public function testSetName(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals('757-200', $aircraftType->getName());
    }

    /**
     * @testdox Sets the aircraft type never exceed speed.
     */
    public function testSetNeverExceedSpeed(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(543, $aircraftType->getNeverExceedSpeed());
    }

    /**
     * @testdox Sets the aircraft type operating empty weight.
     */
    public function testSetOew(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(58440, $aircraftType->getOew());
    }

    /**
     * @testdox Sets the aircraft type operating range.
     */
    public function testSetOperatingRange(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(3915, $aircraftType->getOperatingRange());
    }

    /**
     * @testdox Sets the aircraft type service ceiling.
     */
    public function testSetServiceCeiling(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(42000, $aircraftType->getServiceCeiling());
    }

    /**
     * @testdox Sets the aircraft type certificate URL.
     */
    public function testSetTypeCertificate(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(
            'https://www.easa.europa.eu/document-library/type-certificates/aircraft-cs-25-cs-22-cs-23-cs-vla-cs-lsa/easaima205',
            $aircraftType->getTypeCertificate()
        );
    }

    /**
     * @testdox Sets the aircraft type wing area.
     */
    public function testSetWingArea(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(185.25, $aircraftType->getWingArea());
    }

    /**
     * @testdox Sets the aircraft type wingspan.
     */
    public function testSetWingspan(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals(38.0, $aircraftType->getWingspan());
    }

    /**
     * @testdox Sets the aircraft type ICAO wake turbulence category.
     */
    public function testSetWtc(): void
    {
        $aircraftTypeFactory = new AircraftTypeFactory();
        $aircraftType = $aircraftTypeFactory->createFromCsv(self::$data);

        self::assertEquals('M', $aircraftType->getWtc());
    }
}
