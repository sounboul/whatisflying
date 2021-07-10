<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Aircraft;
use App\Entity\Airline;
use App\Entity\AirlineLogo;
use App\Entity\AirlinePicture;
use App\Entity\Flight;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Airline
 */
final class AirlineTest extends TestCase
{
    /**
     * @testdox Sets/gets the number of accidents involving the airline during the last 5 years.
     */
    public function testAccidentsLast5Years(): void
    {
        $airline = new Airline();
        $airline->setAccidentsLast5Years(7);

        self::assertEquals(7, $airline->getAccidentsLast5Years());
    }

    /**
     * @testdox Sets/gets whether the airline is active.
     */
    public function testActive(): void
    {
        $airline = new Airline();
        $airline->setActive(true);

        self::assertEquals(true, $airline->isActive());
    }

    /**
     * @testdox Sets/gets the airline fleet.
     */
    public function testAircraft(): void
    {
        $aircrafts = $this
            ->getMockBuilder(ArrayCollection::class)
            ->getMock();

        $airline = new Airline();
        $airline->setAircraft($aircrafts);

        self::assertEquals($aircrafts, $airline->getAircraft());

        $firstAircraft = $this
            ->getMockBuilder(Aircraft::class)
            ->getMock();

        $secondAircraft = $this
            ->getMockBuilder(Aircraft::class)
            ->getMock();

        $airline = new Airline();
        $airline->addAircraft($firstAircraft);
        $airline->addAircraft($secondAircraft);
        $airline->addAircraft($secondAircraft);

        self::assertCount(2, $airline->getAircraft());

        $airline->removeAircraft($firstAircraft);

        self::assertCount(1, $airline->getAircraft());
    }

    /**
     * @testdox Sets/gets the number of aircraft over 25 years old within the airline fleet.
     */
    public function testAircraftOver25Years(): void
    {
        $airline = new Airline();
        $airline->setAircraftOver25Years(0);

        self::assertEquals(0, $airline->getAircraftOver25Years());
    }

    /**
     * @testdox Sets/gets the number of domestic flights operated annually by the airline.
     */
    public function testAnnualDomesticFlights(): void
    {
        $airline = new Airline();
        $airline->setAnnualDomesticFlights(96789);

        self::assertEquals(96789, $airline->getAnnualDomesticFlights());
    }

    /**
     * @testdox Sets/gets the number of international flights operated annually by the airline.
     */
    public function testAnnualInternationalFlights(): void
    {
        $airline = new Airline();
        $airline->setAnnualInternationalFlights(171510);

        self::assertEquals(171510, $airline->getAnnualInternationalFlights());
    }

    /**
     * @testdox Sets/gets the airline average fleet age.
     */
    public function testAverageFleetAge(): void
    {
        $airline = new Airline();
        $airline->setAverageFleetAge(10.84);

        self::assertEquals(10.84, $airline->getAverageFleetAge());
    }

    /**
     * @testdox Sets/gets the airline callsign.
     */
    public function testCallsign(): void
    {
        $airline = new Airline();
        $airline->setCallsign('AIRFRANS');

        self::assertEquals('AIRFRANS', $airline->getCallsign());
    }

    /**
     * @testdox Sets/gets the airline registration country.
     */
    public function testCountry(): void
    {
        $airline = new Airline();
        $airline->setCountry('FR');

        self::assertEquals('FR', $airline->getCountry());
    }

    /**
     * @testdox Sets/gets the number of destinations serviced by the airline.
     */
    public function testDestinations(): void
    {
        $airline = new Airline();
        $airline->setDestinations(178);

        self::assertEquals(178, $airline->getDestinations());
    }

    /**
     * @testdox Sets/gets the number of fatal accidents involving the airline during the last 5 years.
     */
    public function testFatalAccidentsLast5Years(): void
    {
        $airline = new Airline();
        $airline->setFatalAccidentsLast5Years(0);

        self::assertEquals(0, $airline->getFatalAccidentsLast5Years());
    }

    /**
     * @testdox Sets/gets the airline flights.
     */
    public function testFlights(): void
    {
        $flights = $this
            ->getMockBuilder(ArrayCollection::class)
            ->getMock();

        $airline = new Airline();
        $airline->setFlights($flights);

        self::assertEquals($flights, $airline->getFlights());

        $firstFlight = $this
            ->getMockBuilder(Flight::class)
            ->getMock();

        $secondFlight = $this
            ->getMockBuilder(Flight::class)
            ->getMock();

        $airline = new Airline();
        $airline->addFlight($firstFlight);
        $airline->addFlight($secondFlight);
        $airline->addFlight($secondFlight);

        self::assertCount(2, $airline->getFlights());

        $airline->removeFlight($secondFlight);

        self::assertCount(1, $airline->getFlights());
    }

    /**
     * @testdox Sets/gets the airline IATA code.
     */
    public function testIataCode(): void
    {
        $airline = new Airline();
        $airline->setIataCode('AF');

        self::assertEquals('AF', $airline->getIataCode());
    }

    /**
     * @testdox Sets/gets whether the airline is member of the IATA.
     */
    public function testIataMember(): void
    {
        $airline = new Airline();
        $airline->setIataMember(true);

        self::assertEquals(true, $airline->isIataMember());
    }

    /**
     * @testdox Sets/gets the airline ICAO code.
     */
    public function testIcaoCode(): void
    {
        $airline = new Airline();
        $airline->setIcaoCode('AFR');

        self::assertEquals('AFR', $airline->getIcaoCode());
    }

    /**
     * @testdox Sets/gets whether the airline operates international flights.
     */
    public function testInternational(): void
    {
        $airline = new Airline();
        $airline->setInternational(true);

        self::assertEquals(true, $airline->isInternational());
    }

    /**
     * @testdox Sets/gets whether the airline is IOSA certified.
     */
    public function testIosaCertified(): void
    {
        $airline = new Airline();
        $airline->setIosaCertified(true);

        self::assertEquals(true, $airline->isIosaCertified());
    }

    /**
     * @testdox Sets/gets the airline logo.
     */
    public function testLogo(): void
    {
        $logo = $this
            ->getMockBuilder(AirlineLogo::class)
            ->getMock();

        $airline = new Airline();
        $airline->setLogo($logo);

        self::assertEquals($logo, $airline->getLogo());
    }

    /**
     * @testdox Sets/gets the airline name.
     */
    public function testName(): void
    {
        $airline = new Airline();
        $airline->setName('Air France');

        self::assertEquals('Air France', $airline->getName());
    }

    /**
     * @testdox Sets/gets the airline pictures.
     */
    public function testPictures(): void
    {
        $pictures = $this
            ->getMockBuilder(ArrayCollection::class)
            ->getMock();

        $airline = new Airline();
        $airline->setPictures($pictures);

        self::assertEquals($pictures, $airline->getPictures());

        $firstPicture = $this
            ->getMockBuilder(AirlinePicture::class)
            ->getMock();

        $secondPicture = $this
            ->getMockBuilder(AirlinePicture::class)
            ->getMock();

        $airline = new Airline();

        self::assertEquals(null, $airline->getFirstPicture());

        $airline->addPicture($firstPicture);
        $airline->addPicture($secondPicture);
        $airline->addPicture($secondPicture);

        self::assertEquals($firstPicture, $airline->getFirstPicture());
        self::assertCount(2, $airline->getPictures());

        $airline->removePicture($secondPicture);

        self::assertCount(1, $airline->getPictures());
    }
}
