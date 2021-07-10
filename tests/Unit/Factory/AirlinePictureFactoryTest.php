<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\Airline;
use App\Factory\AirlinePictureFactory;
use App\Repository\AirlineRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\AirlinePictureFactory
 */
final class AirlinePictureFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'airline' => 'AFR',
        'author_name' => 'John Doe',
        'author_profile' => 'https://www.flickr.com/photos/johndoe/',
        'license' => 'CC-BY-SA-2.0',
        'source' => 'https://www.flickr.com/photos/johndoe/123456789/',
    ];

    private MockObject|AirlineRepository $airlineRepository;
    private MockObject|EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->airlineRepository = $this
            ->getMockBuilder(AirlineRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findOneBy'])
            ->getMock();

        $this->entityManager = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->onlyMethods(['getRepository'])
            ->getMockForAbstractClass();

        $this->entityManager
            ->method('getRepository')
            ->with(Airline::class)
            ->will(self::returnValue($this->airlineRepository));
    }

    /**
     * @testdox Sets the airline to which the picture belongs.
     */
    public function testSetAirline(): void
    {
        $airline = $this
            ->getMockBuilder(Airline::class)
            ->getMock();

        $this->airlineRepository
            ->method('findOneBy')
            ->with(['icaoCode' => 'AFR'])
            ->will(self::returnValue($airline));

        $airlinePictureFactory = new AirlinePictureFactory($this->entityManager);
        $airlinePicture = $airlinePictureFactory->createFromCsv(self::$data);

        self::assertEquals($airline, $airlinePicture->getAirline());
    }
}
