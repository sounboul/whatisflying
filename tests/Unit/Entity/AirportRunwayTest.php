<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Airport;
use App\Entity\AirportRunway;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\AirportRunway
 */
final class AirportRunwayTest extends TestCase
{
    /**
     * @testdox Sets/gets whether the runway is active.
     */
    public function testActive(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setActive(true);

        self::assertEquals(true, $airportRunway->isActive());
    }

    /**
     * @testdox Sets/gets the airport to which the runway belongs.
     */
    public function testAirport(): void
    {
        $airport = $this
            ->getMockBuilder(Airport::class)
            ->getMock();

        $airportRunway = new AirportRunway();
        $airportRunway->setAirport($airport);

        self::assertEquals($airport, $airportRunway->getAirport());
    }

    /**
     * @testdox Sets/gets the runway higher end displaced threshold length.
     */
    public function testHEDisplacedThreshold(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setHEDisplacedThreshold(120);

        self::assertEquals(120, $airportRunway->getHEDisplacedThreshold());
    }

    /**
     * @testdox Sets/gets the runway higher end elevation.
     */
    public function testHEElevation(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setHEElevation(497);

        self::assertEquals(497, $airportRunway->getHEElevation());
    }

    /**
     * @testdox Sets/gets the runway higher end magnetic heading.
     */
    public function testHEHeading(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setHEHeading(323.3);

        self::assertEquals(323.3, $airportRunway->getHEHeading());
    }

    /**
     * @testdox Sets/gets the runway higher end latitude.
     */
    public function testHELatitude(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setHELatitude(43.6156);

        self::assertEquals(43.6156, $airportRunway->getHELatitude());
    }

    /**
     * @testdox Sets/gets the runway higher end longitude.
     */
    public function testHELongitude(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setHELongitude(1.38022);

        self::assertEquals(1.38022, $airportRunway->getHELongitude());
    }

    /**
     * @testdox Sets/gets the runway higher end name.
     */
    public function testHEName(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setHEName('32R');

        self::assertEquals('32R', $airportRunway->getHEName());
    }

    /**
     * @testdox Sets/gets the runway length.
     */
    public function testLength(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setLength(9843);

        self::assertEquals(9843, $airportRunway->getLength());
    }

    /**
     * @testdox Sets/gets whether the runway is lighted.
     */
    public function testLighted(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setLighted(true);

        self::assertEquals(true, $airportRunway->isLighted());
    }

    /**
     * @testdox Sets/gets the runway lower end displaced threshold length.
     */
    public function testLEDisplacedThreshold(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setLEDisplacedThreshold(60);

        self::assertEquals(60, $airportRunway->getLEDisplacedThreshold());
    }

    /**
     * @testdox Sets/gets the runway lower end elevation.
     */
    public function testLEElevation(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setLEElevation(490);

        self::assertEquals(490, $airportRunway->getLEElevation());
    }

    /**
     * @testdox Sets/gets the runway lower end magnetic heading.
     */
    public function testLEHeading(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setLEHeading(143.2);

        self::assertEquals(143.2, $airportRunway->getLEHeading());
    }

    /**
     * @testdox Sets/gets the runway lower end latitude.
     */
    public function testLELatitude(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setLELatitude(43.6374);

        self::assertEquals(43.6374, $airportRunway->getLELatitude());
    }

    /**
     * @testdox Sets/gets the runway lower end longitude.
     */
    public function testLELongitude(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setLELongitude(1.35762);

        self::assertEquals(1.35762, $airportRunway->getLELongitude());
    }

    /**
     * @testdox Sets/gets the runway lower end name.
     */
    public function testLEName(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setLEName('14L');

        self::assertEquals('14L', $airportRunway->getLEName());
    }

    /**
     * @testdox Sets/gets the runway surface.
     */
    public function testSurface(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setSurface('ASP');

        self::assertEquals('ASP', $airportRunway->getSurface());
    }

    /**
     * @testdox Sets/gets the runway width.
     */
    public function testWidth(): void
    {
        $airportRunway = new AirportRunway();
        $airportRunway->setWidth(148);

        self::assertEquals(148, $airportRunway->getWidth());
    }
}
