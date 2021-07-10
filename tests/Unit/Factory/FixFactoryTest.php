<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\Airport;
use App\Factory\FixFactory;
use App\Repository\AirportRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\FixFactory
 */
final class FixFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'airport' => 'LFBO',
        'identifier' => 'ABLIS',
        'latitude' => '44.064944444',
        'longitude' => '1.481805556',
        'region' => 'LF',
        'slug' => 'ablis-lf-lfbo',
        'usage' => 'TERMINAL',
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
     * @testdox Sets the airport to which the fix is associated.
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

        $fixFactory = new FixFactory($this->entityManager);
        $fix = $fixFactory->createFromCsv(self::$data);

        self::assertEquals($airport, $fix->getAirport());
    }

    /**
     * @testdox Sets the fix identifier.
     */
    public function testSetIdentifier(): void
    {
        $fixFactory = new FixFactory($this->entityManager);
        $fix = $fixFactory->createFromCsv(self::$data);

        self::assertEquals('ABLIS', $fix->getIdentifier());
    }

    /**
     * @testdox Sets the fix latitude.
     */
    public function testSetLatitude(): void
    {
        $fixFactory = new FixFactory($this->entityManager);
        $fix = $fixFactory->createFromCsv(self::$data);

        self::assertEquals(44.06494, $fix->getLatitude());
    }

    /**
     * @testdox Sets the fix longitude.
     */
    public function testSetLongitude(): void
    {
        $fixFactory = new FixFactory($this->entityManager);
        $fix = $fixFactory->createFromCsv(self::$data);

        self::assertEquals(1.48181, $fix->getLongitude());
    }

    /**
     * @testdox Sets the ICAO region to which the fix belongs.
     */
    public function testSetRegion(): void
    {
        $fixFactory = new FixFactory($this->entityManager);
        $fix = $fixFactory->createFromCsv(self::$data);

        self::assertEquals('LF', $fix->getRegion());
    }

    /**
     * @testdox Sets the fix slug.
     */
    public function testSetSlug(): void
    {
        $fixFactory = new FixFactory($this->entityManager);
        $fix = $fixFactory->createFromCsv(self::$data);

        self::assertEquals('ablis-lf-lfbo', $fix->getSlug());
    }

    /**
     * @testdox Sets the fix usage type.
     */
    public function testSetUsage(): void
    {
        $fixFactory = new FixFactory($this->entityManager);
        $fix = $fixFactory->createFromCsv(self::$data);

        self::assertEquals('TERMINAL', $fix->getUsage());
    }
}
