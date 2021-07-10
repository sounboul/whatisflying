<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\AircraftType;
use App\Factory\AircraftTypePictureFactory;
use App\Repository\AircraftTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\AircraftTypePictureFactory
 */
final class AircraftTypePictureFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'aircraft_type' => 'A320',
        'author_name' => 'John Doe',
        'author_profile' => 'https://www.flickr.com/photos/johndoe/',
        'license' => 'CC-BY-SA-2.0',
        'source' => 'https://www.flickr.com/photos/johndoe/123456789/',
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
     * @testdox Sets the aircraft type to which the picture belongs.
     */
    public function testSetAircraft(): void
    {
        $aircraftType = $this
            ->getMockBuilder(AircraftType::class)
            ->getMock();

        $this->aircraftTypeRepository
            ->method('findOneBy')
            ->with(['icaoCode' => 'A320'])
            ->will(self::returnValue($aircraftType));

        $aircraftTypePictureFactory = new AircraftTypePictureFactory($this->entityManager);
        $aircraftTypePicture = $aircraftTypePictureFactory->createFromCsv(self::$data);

        self::assertEquals($aircraftType, $aircraftTypePicture->getAircraftType());
    }
}
