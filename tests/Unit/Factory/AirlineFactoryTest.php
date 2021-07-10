<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Factory\AirlineFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\AirlineFactory
 */
final class AirlineFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'accidents_last_5_years' => '7',
        'active' => '1',
        'aircraft_over_25_years' => '0',
        'annual_domestic_flights' => '96789',
        'annual_international_flights' => '171510',
        'average_fleet_age' => '10.84',
        'callsign' => 'AIRFRANS',
        'country' => 'FR',
        'destinations' => '178',
        'fatal_accidents_last_5_years' => '0',
        'iata_code' => 'AF',
        'iata_member' => '1',
        'icao_code' => 'AFR',
        'international' => '1',
        'iosa_certified' => '1',
        'name' => 'Air France',
    ];

    /**
     * @testdox Sets the number of accidents involving the airline during the last 5 years.
     */
    public function testSetAccidentsLast5Years(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals(7, $airline->getAccidentsLast5Years());
    }

    /**
     * @testdox Sets whether the airline is active.
     */
    public function testSetActive(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals(true, $airline->isActive());
    }

    /**
     * @testdox Sets the number of aircraft over 25 years old within the airline fleet.
     */
    public function testSetAircraftOver25Years(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals(0, $airline->getAircraftOver25Years());
    }

    /**
     * @testdox Sets the number of domestic flights operated annually by the airline.
     */
    public function testSetAnnualDomesticFlights(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals(96789, $airline->getAnnualDomesticFlights());
    }

    /**
     * @testdox Sets the number of international flights operated annually by the airline.
     */
    public function testSetAnnualInternationalFlights(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals(171510, $airline->getAnnualInternationalFlights());
    }

    /**
     * @testdox Sets the airline average fleet age.
     */
    public function testSetAverageFleetAge(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals(10.84, $airline->getAverageFleetAge());
    }

    /**
     * @testdox Sets the airline callsign.
     */
    public function testSetCallsign(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals('AIRFRANS', $airline->getCallsign());
    }

    /**
     * @testdox Sets the airline registration country.
     */
    public function testSetCountry(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals('FR', $airline->getCountry());
    }

    /**
     * @testdox Sets the number of destinations serviced by the airline.
     */
    public function testSetDestinations(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals(178, $airline->getDestinations());
    }

    /**
     * @testdox Sets the number of fatal accidents involving the airline during the last 5 years.
     */
    public function testSetFatalAccidentsLast5Years(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals(0, $airline->getFatalAccidentsLast5Years());
    }

    /**
     * @testdox Sets the airline IATA code.
     */
    public function testSetIataCode(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals('AF', $airline->getIataCode());
    }

    /**
     * @testdox Sets whether the airline is member of the IATA.
     */
    public function testSetIataMember(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals(true, $airline->isIataMember());
    }

    /**
     * @testdox Sets the airline ICAO code.
     */
    public function testSetIcaoCode(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals('AFR', $airline->getIcaoCode());
    }

    /**
     * @testdox Sets whether the airline operates international flights.
     */
    public function testSetInternational(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals(true, $airline->isInternational());
    }

    /**
     * @testdox Sets whether the airline is IOSA certified.
     */
    public function testSetIosaCertified(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals(true, $airline->isIosaCertified());
    }

    /**
     * @testdox Sets the airline name.
     */
    public function testSetName(): void
    {
        $airlineFactory = new AirlineFactory();
        $airline = $airlineFactory->createFromCsv(self::$data);

        self::assertEquals('Air France', $airline->getName());
    }
}
