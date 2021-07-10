<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\Fir;
use App\Factory\AirportFactory;
use App\Repository\FirRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\AirportFactory
 */
final class AirportFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'active' => '1',
        'continent' => 'EU',
        'country' => 'FR',
        'elevation' => '482',
        'fir' => 'LFBB',
        'iata_code' => 'TLS',
        'icao_code' => 'LFBO',
        'international' => '1',
        'latitude' => '43.635',
        'longitude' => '1.36778',
        'name' => 'Toulouse-Blagnac Airport',
        'type' => 'large',
    ];

    private MockObject|EntityManagerInterface $entityManager;
    private MockObject|FirRepository $firRepository;

    public function setUp(): void
    {
        $this->firRepository = $this
            ->getMockBuilder(FirRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findOneBy'])
            ->getMock();

        $this->entityManager = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->onlyMethods(['getRepository'])
            ->getMockForAbstractClass();

        $this->entityManager
            ->method('getRepository')
            ->with(Fir::class)
            ->will(self::returnValue($this->firRepository));
    }

    /**
     * @testdox Sets whether the airport is active.
     */
    public function testSetActive(): void
    {
        $airportFactory = new AirportFactory($this->entityManager);
        $airport = $airportFactory->createFromCsv(self::$data);

        self::assertEquals(true, $airport->isActive());
    }

    /**
     * @testdox Sets the continent where the airport is located.
     */
    public function testSetContinent(): void
    {
        $airportFactory = new AirportFactory($this->entityManager);
        $airport = $airportFactory->createFromCsv(self::$data);

        self::assertEquals('EU', $airport->getContinent());
    }

    /**
     * @testdox Sets the country where the airport is located.
     */
    public function testSetCountry(): void
    {
        $airportFactory = new AirportFactory($this->entityManager);
        $airport = $airportFactory->createFromCsv(self::$data);

        self::assertEquals('FR', $airport->getCountry());
    }

    /**
     * @testdox Sets the airport elevation.
     */
    public function testSetElevation(): void
    {
        $airportFactory = new AirportFactory($this->entityManager);
        $airport = $airportFactory->createFromCsv(self::$data);

        self::assertEquals(482, $airport->getElevation());
    }

    /**
     * @testdox Sets the flight information region to which the airport belongs.
     */
    public function testSetFir(): void
    {
        $fir = $this
            ->getMockBuilder(Fir::class)
            ->getMock();

        $this->firRepository
            ->method('findOneBy')
            ->with(['icaoCode' => 'LFBB'])
            ->will(self::returnValue($fir));

        $airportFactory = new AirportFactory($this->entityManager);
        $airport = $airportFactory->createFromCsv(self::$data);

        self::assertEquals($fir, $airport->getFir());
    }

    /**
     * @testdox Sets the airport IATA code.
     */
    public function testSetIataCode(): void
    {
        $airportFactory = new AirportFactory($this->entityManager);
        $airport = $airportFactory->createFromCsv(self::$data);

        self::assertEquals('TLS', $airport->getIataCode());
    }

    /**
     * @testdox Sets the airport ICAO code.
     */
    public function testSetIcaoCode(): void
    {
        $airportFactory = new AirportFactory($this->entityManager);
        $airport = $airportFactory->createFromCsv(self::$data);

        self::assertEquals('LFBO', $airport->getIcaoCode());
    }

    /**
     * @testdox Sets whether the airport is international.
     */
    public function testSetInternational(): void
    {
        $airportFactory = new AirportFactory($this->entityManager);
        $airport = $airportFactory->createFromCsv(self::$data);

        self::assertEquals(true, $airport->isInternational());
    }

    /**
     * @testdox Sets the airport latitude.
     */
    public function testSetLatitude(): void
    {
        $airportFactory = new AirportFactory($this->entityManager);
        $airport = $airportFactory->createFromCsv(self::$data);

        self::assertEquals(43.635, $airport->getLatitude());
    }

    /**
     * @testdox Sets the airport longitude.
     */
    public function testSetLongitude(): void
    {
        $airportFactory = new AirportFactory($this->entityManager);
        $airport = $airportFactory->createFromCsv(self::$data);

        self::assertEquals(1.36778, $airport->getLongitude());
    }

    /**
     * @testdox Sets the airport name.
     */
    public function testSetName(): void
    {
        $airportFactory = new AirportFactory($this->entityManager);
        $airport = $airportFactory->createFromCsv(self::$data);

        self::assertEquals('Toulouse-Blagnac Airport', $airport->getName());
    }

    /**
     * @testdox Sets the airport type.
     */
    public function testSetType(): void
    {
        $airportFactory = new AirportFactory($this->entityManager);
        $airport = $airportFactory->createFromCsv(self::$data);

        self::assertEquals('large', $airport->getType());
    }
}
