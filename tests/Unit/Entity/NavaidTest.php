<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Airport;
use App\Entity\Navaid;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Navaid
 */
final class NavaidTest extends TestCase
{
    /**
     * @testdox Sets/gets the airport to which the navaid is associated.
     */
    public function testAirport(): void
    {
        $airport = $this
            ->getMockBuilder(Airport::class)
            ->getMock();

        $navaid = new Navaid();
        $navaid->setAirport($airport);

        self::assertEquals($airport, $navaid->getAirport());
    }

    /**
     * @testdox Sets/gets the airport runway to which the navaid is associated.
     */
    public function testAirportRunway(): void
    {
        $navaid = new Navaid();
        $navaid->setAirportRunway('29L');

        self::assertEquals('29L', $navaid->getAirportRunway());
    }

    /**
     * @testdox Sets/gets the country where the navaid is located.
     */
    public function testCountry(): void
    {
        $navaid = new Navaid();
        $navaid->setCountry('DK');

        self::assertEquals('DK', $navaid->getCountry());
    }

    /**
     * @testdox Sets/gets the bias of the navaid DME part.
     */
    public function testDmeBias(): void
    {
        $navaid = new Navaid();
        $navaid->setDmeBias(0.2);

        self::assertEquals(0.2, $navaid->getDmeBias());
    }

    /**
     * @testdox Sets/gets the channel of the navaid DME part.
     */
    public function testDmeChannel(): void
    {
        $navaid = new Navaid();
        $navaid->setDmeChannel('114X');

        self::assertEquals('114X', $navaid->getDmeChannel());
    }

    /**
     * @testdox Sets/gets the RX frequency of the navaid DME part.
     */
    public function testDmeRXFrequency(): void
    {
        $navaid = new Navaid();
        $navaid->setDmeRXFrequency(1138000);

        self::assertEquals(1138000, $navaid->getDmeRXFrequency());
    }

    /**
     * @testdox Sets/gets the TX frequency of the navaid DME part.
     */
    public function testDmeTXFrequency(): void
    {
        $navaid = new Navaid();
        $navaid->setDmeTXFrequency(1201000);

        self::assertEquals(1201000, $navaid->getDmeTXFrequency());
    }

    /**
     * @testdox Sets/gets the navaid elevation.
     */
    public function testElevation(): void
    {
        $navaid = new Navaid();
        $navaid->setElevation(57);

        self::assertEquals(57, $navaid->getElevation());
    }

    /**
     * @testdox Sets/gets the navaid frequency.
     */
    public function testFrequency(): void
    {
        $navaid = new Navaid();
        $navaid->setFrequency(116700);

        self::assertEquals(116700, $navaid->getFrequency());
    }

    /**
     * @testdox Sets/gets the angle of the navaid glide slope part.
     */
    public function testGlideSlopeAngle(): void
    {
        $navaid = new Navaid();
        $navaid->setGlideSlopeAngle(3.3);

        self::assertEquals(3.3, $navaid->getGlideSlopeAngle());
    }

    /**
     * @testdox Sets/gets the navaid identifier.
     */
    public function testIdentifier(): void
    {
        $navaid = new Navaid();
        $navaid->setIdentifier('AAL');

        self::assertEquals('AAL', $navaid->getIdentifier());
    }

    /**
     * @testdox Sets/gets the navaid latitude.
     */
    public function testLatitude(): void
    {
        $navaid = new Navaid();
        $navaid->setLatitude(57.103719444);

        self::assertEquals(57.103719444, $navaid->getLatitude());
    }

    /**
     * @testdox Sets/gets the magnetic heading of the navaid localizer part.
     */
    public function testLocalizerHeading(): void
    {
        $navaid = new Navaid();
        $navaid->setLocalizerHeading(292);

        self::assertEquals(292, $navaid->getLocalizerHeading());
    }

    /**
     * @testdox Sets/gets the navaid longitude.
     */
    public function testLongitude(): void
    {
        $navaid = new Navaid();
        $navaid->setLongitude(9.995577778);

        self::assertEquals(9.995577778, $navaid->getLongitude());
    }

    /**
     * @testdox Sets/gets the navaid name.
     */
    public function testName(): void
    {
        $navaid = new Navaid();
        $navaid->setName('AALBORG VORTAC');

        self::assertEquals('AALBORG VORTAC', $navaid->getName());
    }

    /**
     * @testdox Sets/gets the navaid reception range.
     */
    public function testReceptionRange(): void
    {
        $navaid = new Navaid();
        $navaid->setReceptionRange(130);

        self::assertEquals(130, $navaid->getReceptionRange());
    }

    /**
     * @testdox Sets/gets the ICAO region to which the navaid belongs.
     */
    public function testRegion(): void
    {
        $navaid = new Navaid();
        $navaid->setRegion('EK');

        self::assertEquals('EK', $navaid->getRegion());
    }

    /**
     * @testdox Sets/gets the navaid slug.
     */
    public function testSlug(): void
    {
        $navaid = new Navaid();
        $navaid->setSlug('aal-vortac-ek');

        self::assertEquals('aal-vortac-ek', $navaid->getSlug());
    }

    /**
     * @testdox Sets/gets the navaid type.
     */
    public function testType(): void
    {
        $navaid = new Navaid();
        $navaid->setType('VORTAC');

        self::assertEquals('VORTAC', $navaid->getType());
    }

    /**
     * @testdox Sets/gets the navaid usage type.
     */
    public function testUsage(): void
    {
        $navaid = new Navaid();
        $navaid->setUsage('ENROUTE');

        self::assertEquals('ENROUTE', $navaid->getUsage());
    }

    /**
     * @testdox Sets/gets the slaved variation of the navaid VOR part.
     */
    public function testVorSlavedVariation(): void
    {
        $navaid = new Navaid();
        $navaid->setVorSlavedVariation(3.0);

        self::assertEquals(3.0, $navaid->getVorSlavedVariation());
    }
}
