<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\Airline;
use App\Entity\Airport;
use App\Factory\FlightFactory;
use App\Repository\AirlineRepository;
use App\Repository\AirportRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\FlightFactory
 */
final class FlightFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'airline' => 'CYP',
        'arrival_airport' => 'LSZH',
        'departure_airport' => 'LCLK',
        'flight_number' => 'CYP352',
        'layover_airports' => 'LOWW',
    ];

    private MockObject|AirlineRepository $airlineRepository;
    private MockObject|AirportRepository $airportRepository;
    private MockObject|EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->airlineRepository = $this
            ->getMockBuilder(AirlineRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findOneBy'])
            ->getMock();

        $this->airportRepository = $this
            ->getMockBuilder(AirportRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findOneBy'])
            ->getMock();

        $this->entityManager = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->onlyMethods(['getRepository'])
            ->getMockForAbstractClass();

        $valueMap = [
            [Airline::class, $this->airlineRepository],
            [Airport::class, $this->airportRepository],
        ];

        $this->entityManager
            ->method('getRepository')
            ->will(self::returnValueMap($valueMap));
    }

    /**
     * @testdox Sets the airline for which the flight is operated.
     */
    public function testSetAirline(): void
    {
        $airline = new Airline();

        $this->airlineRepository
            ->method('findOneBy')
            ->with(['icaoCode' => 'CYP'])
            ->will(self::returnValue($airline));

        $flightFactory = new FlightFactory($this->entityManager);
        $flight = $flightFactory->createFromCsv(self::$data);

        self::assertEquals($airline, $flight->getAirline());
    }

    /**
     * @testdox Sets the flight arrival airport.
     */
    public function testSetArrivalAirport(): void
    {
        $airport = $this
            ->getMockBuilder(Airport::class)
            ->getMock();

        $valueMap = [
            [['icaoCode' => 'LCLK'], null, null],
            [['icaoCode' => 'LOWW'], null, null],
            [['icaoCode' => 'LSZH'], null, $airport],
        ];

        $this->airportRepository
            ->method('findOneBy')
            ->will(self::returnValueMap($valueMap));

        $flightFactory = new FlightFactory($this->entityManager);
        $flight = $flightFactory->createFromCsv(self::$data);

        self::assertEquals($airport, $flight->getArrivalAirport());
    }

    /**
     * @testdox Sets the flight departure airport.
     */
    public function testSetDepartureAirport(): void
    {
        $airport = $this
            ->getMockBuilder(Airport::class)
            ->getMock();

        $valueMap = [
            [['icaoCode' => 'LCLK'], null, $airport],
            [['icaoCode' => 'LOWW'], null, null],
            [['icaoCode' => 'LSZH'], null, null],
        ];

        $this->airportRepository
            ->method('findOneBy')
            ->will(self::returnValueMap($valueMap));

        $flightFactory = new FlightFactory($this->entityManager);
        $flight = $flightFactory->createFromCsv(self::$data);

        self::assertEquals($airport, $flight->getDepartureAirport());
    }

    /**
     * @testdox Sets the flight number.
     */
    public function testSetFlightNumber(): void
    {
        $flightFactory = new FlightFactory($this->entityManager);
        $flight = $flightFactory->createFromCsv(self::$data);

        self::assertEquals('CYP352', $flight->getFlightNumber());
    }

    /**
     * @testdox Sets the flight layover airports.
     */
    public function testSetLayoverAirports(): void
    {
        $airport = $this
            ->getMockBuilder(Airport::class)
            ->getMock();

        $valueMap = [
            [['icaoCode' => 'LCLK'], null, null],
            [['icaoCode' => 'LOWW'], null, $airport],
            [['icaoCode' => 'LSZH'], null, null],
        ];

        $this->airportRepository
            ->method('findOneBy')
            ->will(self::returnValueMap($valueMap));

        $flightFactory = new FlightFactory($this->entityManager);
        $flight = $flightFactory->createFromCsv(self::$data);

        self::assertContains($airport, $flight->getLayoverAirports());
    }
}
