<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\Airline;
use App\Factory\AirlineLogoFactory;
use App\Repository\AirlineRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\AirlineLogoFactory
 */
final class AirlineLogoFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'airline' => 'AFR',
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
     * @testdox Sets the airline to which the logo belongs.
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

        $airlineLogoFactory = new AirlineLogoFactory($this->entityManager);
        $airlineLogo = $airlineLogoFactory->createFromCsv(self::$data);

        self::assertEquals($airline, $airlineLogo->getAirline());
    }
}
