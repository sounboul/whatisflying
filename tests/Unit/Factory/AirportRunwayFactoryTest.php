<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\Airport;
use App\Factory\AirportRunwayFactory;
use App\Repository\AirportRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\AirportRunwayFactory
 */
final class AirportRunwayFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'active' => '1',
        'airport' => 'LFBO',
        'he_displaced_threshold' => '120',
        'he_elevation' => '497',
        'he_heading' => '323.3',
        'he_latitude' => '43.6156',
        'he_longitude' => '1.38022',
        'he_name' => '32R',
        'le_displaced_threshold' => '60',
        'le_elevation' => '490',
        'le_heading' => '143.2',
        'le_latitude' => '43.6374',
        'le_longitude' => '1.35762',
        'le_name' => '14L',
        'length' => '9843',
        'lighted' => '1',
        'surface' => 'ASP',
        'width' => '148',
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
     * @testdox Sets whether the runway is active.
     */
    public function testSetActive(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals(true, $airportRunway->isActive());
    }

    /**
     * @testdox Sets the airport to which the runway belongs.
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

        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals($airport, $airportRunway->getAirport());
    }

    /**
     * @testdox Sets the runway higher end displaced threshold length.
     */
    public function testSetHEDisplacedThreshold(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals(120, $airportRunway->getHEDisplacedThreshold());
    }

    /**
     * @testdox Sets the runway higher end elevation.
     */
    public function testSetHEElevation(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals(497, $airportRunway->getHEElevation());
    }

    /**
     * @testdox Sets the runway higher end magnetic heading.
     */
    public function testSetHEHeading(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals(323.3, $airportRunway->getHEHeading());
    }

    /**
     * @testdox Sets the runway higher end latitude.
     */
    public function testSetHELatitude(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals(43.6156, $airportRunway->getHELatitude());
    }

    /**
     * @testdox Sets the runway higher end longitude.
     */
    public function testSetHELongitude(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals(1.38022, $airportRunway->getHELongitude());
    }

    /**
     * @testdox Sets the runway higher end name.
     */
    public function testSetHEName(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals('32R', $airportRunway->getHEName());
    }

    /**
     * @testdox Sets the runway length.
     */
    public function testSetLength(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals(9843, $airportRunway->getLength());
    }

    /**
     * @testdox Sets whether the runway is lighted.
     */
    public function testSetLighted(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals(true, $airportRunway->isLighted());
    }

    /**
     * @testdox Sets the runway lower end displaced threshold length.
     */
    public function testSetLEDisplacedThreshold(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals(60, $airportRunway->getLEDisplacedThreshold());
    }

    /**
     * @testdox Sets the runway lower end elevation.
     */
    public function testSetLEElevation(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals(490, $airportRunway->getLEElevation());
    }

    /**
     * @testdox Sets the runway lower end magnetic heading.
     */
    public function testSetLEHeading(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals(143.2, $airportRunway->getLEHeading());
    }

    /**
     * @testdox Sets the runway lower end latitude.
     */
    public function testSetLELatitude(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals(43.6374, $airportRunway->getLELatitude());
    }

    /**
     * @testdox Sets the runway lower end longitude.
     */
    public function testSetLELongitude(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals(1.35762, $airportRunway->getLELongitude());
    }

    /**
     * @testdox Sets the runway lower end name.
     */
    public function testSetLEName(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals('14L', $airportRunway->getLEName());
    }

    /**
     * @testdox Sets the runway surface.
     */
    public function testSetSurface(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals('ASP', $airportRunway->getSurface());
    }

    /**
     * @testdox Sets the runway width.
     */
    public function testSetWidth(): void
    {
        $airportRunwayFactory = new AirportRunwayFactory($this->entityManager);
        $airportRunway = $airportRunwayFactory->createFromCsv(self::$data);

        self::assertEquals(148, $airportRunway->getWidth());
    }
}
