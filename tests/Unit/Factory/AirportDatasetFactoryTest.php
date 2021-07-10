<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\Airport;
use App\Factory\AirportDatasetFactory;
use App\Repository\AirportRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\AirportDatasetFactory
 */
final class AirportDatasetFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'airport' => 'LFBO',
        'domestic_departures' => '21554',
        'domestic_destinations' => '28',
        'international_departures' => '12586',
        'international_destinations' => '35',
        'year' => '2003',
    ];

    private MockObject|AirportRepository $airportRepository;
    private MockObject|EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->airportRepository = $this
            ->getMockBuilder(AirportRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findOneBy'])
            ->getMock();

        $this->entityManager = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->onlyMethods(['getRepository'])
            ->getMockForAbstractClass();

        $this->entityManager
            ->method('getRepository')
            ->with(Airport::class)
            ->will(self::returnValue($this->airportRepository));
    }

    /**
     * @testdox Sets the airport to which the dataset applies.
     */
    public function testSetAirport(): void
    {
        $airport = $this
            ->getMockBuilder(Airport::class)
            ->getMock();

        $this->airportRepository
            ->method('findOneBy')
            ->with(['icaoCode' => 'LFBO'])
            ->will(self::returnValue($airport));

        $airportDatasetFactory = new AirportDatasetFactory($this->entityManager);
        $airportDataset = $airportDatasetFactory->createFromCsv(self::$data);

        self::assertEquals($airport, $airportDataset->getAirport());
    }

    /**
     * @testdox Sets the number of domestic flights that departed from the airport.
     */
    public function testSetDomesticDepartures(): void
    {
        $airportDatasetFactory = new AirportDatasetFactory($this->entityManager);
        $airportDataset = $airportDatasetFactory->createFromCsv(self::$data);

        self::assertEquals(21554, $airportDataset->getDomesticDepartures());
    }

    /**
     * @testdox Sets the number of domestic destinations serviced by the airport.
     */
    public function testSetDomesticDestinations(): void
    {
        $airportDatasetFactory = new AirportDatasetFactory($this->entityManager);
        $airportDataset = $airportDatasetFactory->createFromCsv(self::$data);

        self::assertEquals(28, $airportDataset->getDomesticDestinations());
    }

    /**
     * @testdox Sets the number of international flights that departed from the airport.
     */
    public function testSetInternationalDepartures(): void
    {
        $airportDatasetFactory = new AirportDatasetFactory($this->entityManager);
        $airportDataset = $airportDatasetFactory->createFromCsv(self::$data);

        self::assertEquals(12586, $airportDataset->getInternationalDepartures());
    }

    /**
     * @testdox Sets the number of international destinations serviced by the airport.
     */
    public function testSetInternationalDestinations(): void
    {
        $airportDatasetFactory = new AirportDatasetFactory($this->entityManager);
        $airportDataset = $airportDatasetFactory->createFromCsv(self::$data);

        self::assertEquals(35, $airportDataset->getInternationalDestinations());
    }

    /**
     * @testdox Sets the dataset year.
     */
    public function testSetYear(): void
    {
        $airportDatasetFactory = new AirportDatasetFactory($this->entityManager);
        $airportDataset = $airportDatasetFactory->createFromCsv(self::$data);

        self::assertEquals(2003, $airportDataset->getYear());
    }
}
