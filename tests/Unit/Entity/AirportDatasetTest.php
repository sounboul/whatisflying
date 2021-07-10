<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Airport;
use App\Entity\AirportDataset;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\AirportDataset
 */
final class AirportDatasetTest extends TestCase
{
    /**
     * @testdox Sets/gets airport to which the dataset applies.
     */
    public function testAirport(): void
    {
        $airport = $this
            ->getMockBuilder(Airport::class)
            ->getMock();

        $airportDataset = new AirportDataset();
        $airportDataset->setAirport($airport);

        self::assertEquals($airport, $airportDataset->getAirport());
    }

    /**
     * @testdox Sets/gets the number of domestic flights that departed from the airport.
     */
    public function testDomesticDepartures(): void
    {
        $airportDataset = new AirportDataset();
        $airportDataset->setDomesticDepartures(38128);

        self::assertEquals(38128, $airportDataset->getDomesticDepartures());
    }

    /**
     * @testdox Sets/gets the number of domestic destinations serviced by the airport.
     */
    public function testDomesticDestinations(): void
    {
        $airportDataset = new AirportDataset();
        $airportDataset->setDomesticDestinations(104);

        self::assertEquals(104, $airportDataset->getDomesticDestinations());
    }

    /**
     * @testdox Sets/gets the number of international flights that departed from the airport.
     */
    public function testInternationalDepartures(): void
    {
        $airportDataset = new AirportDataset();
        $airportDataset->setInternationalDepartures(14732);

        self::assertEquals(14732, $airportDataset->getInternationalDepartures());
    }

    /**
     * @testdox Sets/gets the number of international destinations serviced by the airport.
     */
    public function testInternationalDestinations(): void
    {
        $airportDataset = new AirportDataset();
        $airportDataset->setInternationalDestinations(47);

        self::assertEquals(47, $airportDataset->getInternationalDestinations());
    }

    /**
     * @testdox Sets/gets the dataset year.
     */
    public function testYear(): void
    {
        $airportDataset = new AirportDataset();
        $airportDataset->setYear(2018);

        self::assertEquals(2018, $airportDataset->getYear());
    }
}
