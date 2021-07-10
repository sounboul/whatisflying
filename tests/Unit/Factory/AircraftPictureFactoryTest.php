<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\Aircraft;
use App\Factory\AircraftPictureFactory;
use App\Repository\AircraftRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\AircraftPictureFactory
 */
final class AircraftPictureFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'aircraft' => 'c0ffee',
        'author_name' => 'John Doe',
        'author_profile' => 'https://www.flickr.com/photos/johndoe/',
        'license' => 'CC-BY-SA-2.0',
        'source' => 'https://www.flickr.com/photos/johndoe/123456789/',
    ];

    private MockObject|AircraftRepository $aircraftRepository;
    private MockObject|EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->aircraftRepository = $this
            ->getMockBuilder(AircraftRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findOneBy'])
            ->getMock();

        $this->entityManager = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->onlyMethods(['getRepository'])
            ->getMockForAbstractClass();

        $this->entityManager
            ->method('getRepository')
            ->with(Aircraft::class)
            ->will(self::returnValue($this->aircraftRepository));
    }

    /**
     * @testdox Sets the aircraft to which the picture belongs.
     */
    public function testSetAircraft(): void
    {
        $aircraft = $this
            ->getMockBuilder(Aircraft::class)
            ->getMock();

        $this->aircraftRepository
            ->method('findOneBy')
            ->with(['icao24bitAddress' => 'c0ffee'])
            ->will(self::returnValue($aircraft));

        $aircraftPictureFactory = new AircraftPictureFactory($this->entityManager);
        $aircraftPicture = $aircraftPictureFactory->createFromCsv(self::$data);

        self::assertEquals($aircraft, $aircraftPicture->getAircraft());
    }
}
