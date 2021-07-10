<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\AircraftType;
use App\Factory\AircraftModelFactory;
use App\Repository\AircraftTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\AircraftModelFactory
 */
final class AircraftModelFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'aircraft_type' => 'A20N',
        'certified_at' => '2019-08-19',
        'engine_manufacturer' => 'Pratt & Whitney',
        'engine_model' => 'PW1124G1-JM',
        'name' => 'A320-272N',
    ];

    private MockObject|AircraftTypeRepository $aircraftTypeRepository;
    private MockObject|EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->aircraftTypeRepository = $this
            ->getMockBuilder(AircraftTypeRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findOneBy'])
            ->getMock();

        $this->entityManager = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->onlyMethods(['getRepository'])
            ->getMockForAbstractClass();

        $this->entityManager
            ->method('getRepository')
            ->with(AircraftType::class)
            ->will(self::returnValue($this->aircraftTypeRepository));
    }

    /**
     * @testdox Sets the aircraft type to which the aircraft model belongs.
     */
    public function testSetAircraftType(): void
    {
        $aircraftType = $this
            ->getMockBuilder(AircraftType::class)
            ->getMock();

        $this->aircraftTypeRepository
            ->method('findOneBy')
            ->with(['icaoCode' => 'A20N'])
            ->will(self::returnValue($aircraftType));

        $aircraftModelFactory = new AircraftModelFactory($this->entityManager);
        $aircraftModel = $aircraftModelFactory->createFromCsv(self::$data);

        self::assertEquals($aircraftType, $aircraftModel->getAircraftType());
    }

    /**
     * @testdox Sets the aircraft model certification date.
     */
    public function testSetCertified(): void
    {
        $aircraftModelFactory = new AircraftModelFactory($this->entityManager);

        $aircraftModel = $aircraftModelFactory->createFromCsv(self::$data);
        self::assertInstanceOf(\DateTime::class, $aircraftModel->getCertified());
    }

    /**
     * @testdox Sets the aircraft model engines manufacturer.
     */
    public function testSetEngineManufacturer(): void
    {
        $aircraftModelFactory = new AircraftModelFactory($this->entityManager);

        $aircraftModel = $aircraftModelFactory->createFromCsv(self::$data);
        self::assertEquals('Pratt & Whitney', $aircraftModel->getEngineManufacturer());
    }

    /**
     * @testdox Sets the aircraft model engines model.
     */
    public function testSetEngineModel(): void
    {
        $aircraftModelFactory = new AircraftModelFactory($this->entityManager);

        $aircraftModel = $aircraftModelFactory->createFromCsv(self::$data);
        self::assertEquals('PW1124G1-JM', $aircraftModel->getEngineModel());
    }

    /**
     * @testdox Sets the aircraft model name.
     */
    public function testSetName(): void
    {
        $aircraftModelFactory = new AircraftModelFactory($this->entityManager);

        $aircraftModel = $aircraftModelFactory->createFromCsv(self::$data);
        self::assertEquals('A320-272N', $aircraftModel->getName());
    }
}
