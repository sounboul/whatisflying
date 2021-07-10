<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\AircraftType;
use App\Entity\Airline;
use App\Factory\AircraftFactory;
use App\Repository\AircraftTypeRepository;
use App\Repository\AirlineRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\AircraftFactory
 */
final class AircraftFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'aircraft_type' => 'A388',
        'description' => 'L4J',
        'icao_24bit_address' => '383f3a',
        'manufactured_at' => '2007-01-01',
        'manufacturer' => 'Airbus',
        'model' => 'A380-841',
        'operator' => 'AIB',
        'registered_at' => '2007-12-21',
        'registered_until' => '2008-01-01',
        'registration' => 'F-WWSG',
        'serial_number' => '10',
    ];

    private MockObject|AircraftTypeRepository $aircraftTypeRepository;
    private MockObject|AirlineRepository $airlineRepository;
    private MockObject|EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->aircraftTypeRepository = $this
            ->getMockBuilder(AircraftTypeRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findOneBy'])
            ->getMock();

        $this->airlineRepository = $this
            ->getMockBuilder(AirlineRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findOneBy'])
            ->getMock();

        $this->entityManager = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->onlyMethods(['getRepository'])
            ->getMockForAbstractClass();

        $valueMap = [
            [AircraftType::class, $this->aircraftTypeRepository],
            [Airline::class, $this->airlineRepository],
        ];

        $this->entityManager
            ->method('getRepository')
            ->will(self::returnValueMap($valueMap));
    }

    /**
     * @testdox Sets the aircraft family to which the aircraft belongs.
     */
    public function testSetAircraftFamily(): void
    {
        $aircraftFactory = new AircraftFactory($this->entityManager);

        $aircraft = $aircraftFactory->createFromCsv(self::$data);
        self::assertEquals('L', $aircraft->getAircraftFamily());
    }

    /**
     * @testdox Sets the aircraft type to which the aircraft belongs.
     */
    public function testSetAircraftType(): void
    {
        $aircraftType = $this
            ->getMockBuilder(AircraftType::class)
            ->getMock();

        $this->aircraftTypeRepository
            ->method('findOneBy')
            ->with(['icaoCode' => 'A388'])
            ->will(self::returnValue($aircraftType));

        $aircraftFactory = new AircraftFactory($this->entityManager);
        $aircraft = $aircraftFactory->createFromCsv(self::$data);

        self::assertEquals($aircraftType, $aircraft->getAircraftType());
    }

    /**
     * @testdox Sets the aircraft description.
     */
    public function testSetDescription(): void
    {
        $aircraftFactory = new AircraftFactory($this->entityManager);

        $aircraft = $aircraftFactory->createFromCsv(self::$data);
        self::assertEquals('L4J', $aircraft->getDescription());
    }

    /**
     * @testdox Sets the aircraft ICAO 24-bit address.
     */
    public function testSetIcao24bitAddress(): void
    {
        $aircraftFactory = new AircraftFactory($this->entityManager);

        $aircraft = $aircraftFactory->createFromCsv(self::$data);
        self::assertEquals('383f3a', $aircraft->getIcao24bitAddress());
    }

    /**
     * @testdox Sets the aircraft engine count.
     */
    public function testSetEngineCount(): void
    {
        $aircraftFactory = new AircraftFactory($this->entityManager);

        $aircraft = $aircraftFactory->createFromCsv(self::$data);
        self::assertEquals(4, $aircraft->getEngineCount());
    }

    /**
     * @testdox Sets the aircraft engine type.
     */
    public function testSetEngineType(): void
    {
        $aircraftFactory = new AircraftFactory($this->entityManager);

        $aircraft = $aircraftFactory->createFromCsv(self::$data);
        self::assertEquals('J', $aircraft->getEngineType());
    }

    /**
     * @testdox Sets the aircraft manufacturing date.
     */
    public function testSetManufactured(): void
    {
        $aircraftFactory = new AircraftFactory($this->entityManager);

        $aircraft = $aircraftFactory->createFromCsv(self::$data);
        self::assertInstanceOf(\DateTime::class, $aircraft->getManufactured());
    }

    /**
     * @testdox Sets the aircraft manufacturer.
     */
    public function testSetManufacturer(): void
    {
        $aircraftFactory = new AircraftFactory($this->entityManager);

        $aircraft = $aircraftFactory->createFromCsv(self::$data);
        self::assertEquals('Airbus', $aircraft->getManufacturer());
    }

    /**
     * @testdox Sets the aircraft model.
     */
    public function testSetModel(): void
    {
        $aircraftFactory = new AircraftFactory($this->entityManager);

        $aircraft = $aircraftFactory->createFromCsv(self::$data);
        self::assertEquals('A380-841', $aircraft->getModel());
    }

    /**
     * @testdox Sets the aircraft operator.
     */
    public function testSetOperator(): void
    {
        $operator = $this
            ->getMockBuilder(Airline::class)
            ->getMock();

        $this->airlineRepository
            ->method('findOneBy')
            ->with(['icaoCode' => 'AIB'])
            ->will(self::returnValue($operator));

        $aircraftFactory = new AircraftFactory($this->entityManager);
        $aircraft = $aircraftFactory->createFromCsv(self::$data);

        self::assertEquals($operator, $aircraft->getOperator());
    }

    /**
     * @testdox Sets the aircraft registration date.
     */
    public function testSetRegistered(): void
    {
        $aircraftFactory = new AircraftFactory($this->entityManager);

        $aircraft = $aircraftFactory->createFromCsv(self::$data);
        self::assertInstanceOf(\DateTime::class, $aircraft->getRegistered());
    }

    /**
     * @testdox Sets the aircraft registration expiration date.
     */
    public function testSetRegisteredUntil(): void
    {
        $aircraftFactory = new AircraftFactory($this->entityManager);

        $aircraft = $aircraftFactory->createFromCsv(self::$data);
        self::assertInstanceOf(\DateTime::class, $aircraft->getRegisteredUntil());
    }

    /**
     * @testdox Sets the aircraft registration.
     */
    public function testSetRegistration(): void
    {
        $aircraftFactory = new AircraftFactory($this->entityManager);

        $aircraft = $aircraftFactory->createFromCsv(self::$data);
        self::assertEquals('F-WWSG', $aircraft->getRegistration());
    }

    /**
     * @testdox Sets the aircraft registration country.
     */
    public function testSetRegistrationCountry(): void
    {
        $aircraftFactory = new AircraftFactory($this->entityManager);

        $aircraft = $aircraftFactory->createFromCsv(self::$data);
        self::assertEquals('FR', $aircraft->getRegistrationCountry());
    }

    /**
     * @testdox Sets the aircraft manufacturer serial number.
     */
    public function testSetSerialNumber(): void
    {
        $aircraftFactory = new AircraftFactory($this->entityManager);

        $aircraft = $aircraftFactory->createFromCsv(self::$data);
        self::assertEquals('10', $aircraft->getSerialNumber());
    }
}
