<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Airport;
use App\Entity\AirportFrequency;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\AirportFrequency
 */
final class AirportFrequencyTest extends TestCase
{
    /**
     * @testdox Sets/gets the airport to which the radio frequency belongs.
     */
    public function testAirport(): void
    {
        $airport = $this
            ->getMockBuilder(Airport::class)
            ->getMock();

        $airportFrequency = new AirportFrequency();
        $airportFrequency->setAirport($airport);

        self::assertEquals($airport, $airportFrequency->getAirport());
    }

    /**
     * @testdox Sets/gets the radio frequency description.
     */
    public function testDescription(): void
    {
        $airportFrequency = new AirportFrequency();
        $airportFrequency->setDescription('Toulouse-Blagnac ATIS');

        self::assertEquals('Toulouse-Blagnac ATIS', $airportFrequency->getDescription());
    }

    /**
     * @testdox Sets/gets the radio frequency.
     */
    public function testFrequency(): void
    {
        $airportFrequency = new AirportFrequency();
        $airportFrequency->setFrequency(123125);

        self::assertEquals(123125, $airportFrequency->getFrequency());
    }

    /**
     * @testdox Sets/gets the radio frequency type.
     */
    public function testType(): void
    {
        $airportFrequency = new AirportFrequency();
        $airportFrequency->setType('ATIS');

        self::assertEquals('ATIS', $airportFrequency->getType());
    }
}
