<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Airline;
use App\Entity\Airport;
use App\Entity\Flight;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Flight
 */
final class FlightTest extends TestCase
{
    /**
     * @testdox Sets/gets the airline for which the flight is operated.
     */
    public function testAirline(): void
    {
        $airline = $this
            ->getMockBuilder(Airline::class)
            ->getMock();

        $flight = new Flight();
        $flight->setAirline($airline);

        self::assertEquals($airline, $flight->getAirline());
    }

    /**
     * @testdox Sets/gets the flight arrival airport.
     */
    public function testArrivalAirport(): void
    {
        $arrivalAirport = $this
            ->getMockBuilder(Airport::class)
            ->getMock();

        $flight = new Flight();
        $flight->setArrivalAirport($arrivalAirport);

        self::assertEquals($arrivalAirport, $flight->getArrivalAirport());
    }

    /**
     * @testdox Sets/gets the flight departure airport.
     */
    public function testDepartureAirport(): void
    {
        $departureAirport = $this
            ->getMockBuilder(Airport::class)
            ->getMock();

        $flight = new Flight();
        $flight->setDepartureAirport($departureAirport);

        self::assertEquals($departureAirport, $flight->getDepartureAirport());
    }

    /**
     * @testdox Sets/gets the flight number.
     */
    public function testFlightNumber(): void
    {
        $flight = new Flight();
        $flight->setFlightNumber('AFR447');

        self::assertEquals('AFR447', $flight->getFlightNumber());
    }

    /**
     * @testdox Sets/gets the flight layover airports.
     */
    public function testLayoverAirports(): void
    {
        $layoverAirports = $this
            ->getMockBuilder(ArrayCollection::class)
            ->getMock();

        $flight = new Flight();
        $flight->setLayoverAirports($layoverAirports);

        self::assertEquals($layoverAirports, $flight->getLayoverAirports());

        $firstLayoverAirport = $this
            ->getMockBuilder(Airport::class)
            ->getMock();

        $secondLayoverAirport = $this
            ->getMockBuilder(Airport::class)
            ->getMock();

        $flight = new Flight();
        $flight->addLayoverAirport($firstLayoverAirport);
        $flight->addLayoverAirport($secondLayoverAirport);
        $flight->addLayoverAirport($secondLayoverAirport);

        self::assertCount(2, $flight->getLayoverAirports());

        $flight->removeLayoverAirport($firstLayoverAirport);

        self::assertCount(1, $flight->getLayoverAirports());
    }
}
