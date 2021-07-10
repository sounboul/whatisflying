<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\Airport;
use App\Factory\AirportFrequencyFactory;
use App\Repository\AirportRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\AirportFrequencyFactory
 */
final class AirportFrequencyFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'airport' => 'LFBO',
        'description' => 'Toulouse-Blagnac ATIS',
        'frequency' => '123125',
        'type' => 'ATIS',
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
     * @testdox Sets the airport to which the radio frequency belongs.
     */
    public function testSetAirport(): void
    {
        $airport = $this
            ->getMockBuilder(Airport::class)
            ->getMock();

        $this->airportRepository
            ->method('findOneBy')
            ->will(self::returnValue($airport));

        $airportFrequencyFactory = new AirportFrequencyFactory($this->entityManager);
        $airportFrequency = $airportFrequencyFactory->createFromCsv(self::$data);

        self::assertEquals($airport, $airportFrequency->getAirport());
    }

    /**
     * @testdox Sets the radio frequency description.
     */
    public function testSetDescription(): void
    {
        $airportFrequencyFactory = new AirportFrequencyFactory($this->entityManager);
        $airportFrequency = $airportFrequencyFactory->createFromCsv(self::$data);

        self::assertEquals('Toulouse-Blagnac ATIS', $airportFrequency->getDescription());
    }

    /**
     * @testdox Sets the radio frequency.
     */
    public function testSetFrequency(): void
    {
        $airportFrequencyFactory = new AirportFrequencyFactory($this->entityManager);
        $airportFrequency = $airportFrequencyFactory->createFromCsv(self::$data);

        self::assertEquals(123125, $airportFrequency->getFrequency());
    }

    /**
     * @testdox Sets the radio frequency type.
     */
    public function testSetType(): void
    {
        $airportFrequencyFactory = new AirportFrequencyFactory($this->entityManager);
        $airportFrequency = $airportFrequencyFactory->createFromCsv(self::$data);

        self::assertEquals('ATIS', $airportFrequency->getType());
    }
}
