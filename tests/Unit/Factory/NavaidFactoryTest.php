<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\Airport;
use App\Factory\NavaidFactory;
use App\Repository\AirportRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Factory\NavaidFactory
 */
final class NavaidFactoryTest extends TestCase
{
    /**
     * @var string[]
     */
    private static array $data = [
        'airport_runway' => '29L',
        'airport' => 'EKRO',
        'country' => 'DK',
        'dme_bias' => '0.2',
        'dme_channel' => '114X',
        'dme_rx_frequency' => '1138000',
        'dme_tx_frequency' => '1201000',
        'elevation' => '57',
        'frequency' => '116700',
        'glide_slope_angle' => '3.3',
        'identifier' => 'AAL',
        'latitude' => '57.103719444',
        'localizer_heading' => '292',
        'longitude' => '9.995577778',
        'name' => 'AALBORG VORTAC',
        'reception_range' => '130',
        'region' => 'EK',
        'slug' => 'aal-vortac-ek',
        'type' => 'VORTAC',
        'usage' => 'ENROUTE',
        'vor_slaved_variation' => '3.000',
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
     * @testdox Sets the airport to which the navaid is associated.
     */
    public function testSetAirport(): void
    {
        $airport = new Airport();

        $this->airportRepository
            ->method('findOneBy')
            ->with(['icaoCode' => 'EKRO'])
            ->will(self::returnValue($airport));

        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals($airport, $navaid->getAirport());
    }

    /**
     * @testdox Sets the airport runway to which the navaid is associated.
     */
    public function testSetAirportRunway(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals('29L', $navaid->getAirportRunway());
    }

    /**
     * @testdox Sets the country where the navaid is located.
     */
    public function testSetCountry(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals('DK', $navaid->getCountry());
    }

    /**
     * @testdox Sets the bias of the navaid DME part.
     */
    public function testSetDmeBias(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals(0.2, $navaid->getDmeBias());
    }

    /**
     * @testdox Sets the channel of the navaid DME part.
     */
    public function testSetDmeChannel(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals('114X', $navaid->getDmeChannel());
    }

    /**
     * @testdox Sets the RX frequency of the navaid DME part.
     */
    public function testSetDmeRXFrequency(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals(1138000, $navaid->getDmeRXFrequency());
    }

    /**
     * @testdox Sets the TX frequency of the navaid DME part.
     */
    public function testSetDmeTXFrequency(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals(1201000, $navaid->getDmeTXFrequency());
    }

    /**
     * @testdox Sets the navaid elevation.
     */
    public function testSetElevation(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals(57, $navaid->getElevation());
    }

    /**
     * @testdox Sets the navaid frequency.
     */
    public function testSetFrequency(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals(116700, $navaid->getFrequency());
    }

    /**
     * @testdox Sets the angle of the navaid glide slope part.
     */
    public function testSetGlideSlopeAngle(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals(3.3, $navaid->getGlideSlopeAngle());
    }

    /**
     * @testdox Sets the navaid identifier.
     */
    public function testSetIdentifier(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals('AAL', $navaid->getIdentifier());
    }

    /**
     * @testdox Sets the navaid latitude.
     */
    public function testSetLatitude(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals(57.10372, $navaid->getLatitude());
    }

    /**
     * @testdox Sets the magnetic heading of the navaid localizer part.
     */
    public function testSetLocalizerHeading(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals(292.0, $navaid->getLocalizerHeading());
    }

    /**
     * @testdox Sets the navaid longitude.
     */
    public function testSetLongitude(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals(9.99558, $navaid->getLongitude());
    }

    /**
     * @testdox Sets the navaid name.
     */
    public function testSetName(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals('AALBORG VORTAC', $navaid->getName());
    }

    /**
     * @testdox Sets the navaid reception range.
     */
    public function testSetReceptionRange(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals(130, $navaid->getReceptionRange());
    }

    /**
     * @testdox Sets the ICAO region to which the navaid belongs.
     */
    public function testSetRegion(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals('EK', $navaid->getRegion());
    }

    /**
     * @testdox Sets the navaid slug.
     */
    public function testSetSlug(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals('aal-vortac-ek', $navaid->getSlug());
    }

    /**
     * @testdox Sets the navaid type.
     */
    public function testSetType(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals('VORTAC', $navaid->getType());
    }

    /**
     * @testdox Sets the navaid usage type.
     */
    public function testSetUsage(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals('ENROUTE', $navaid->getUsage());
    }

    /**
     * @testdox Sets the slaved variation of the navaid VOR part.
     */
    public function testSetVorSlavedVariation(): void
    {
        $navaidFactory = new NavaidFactory($this->entityManager);
        $navaid = $navaidFactory->createFromCsv(self::$data);

        self::assertEquals(3.0, $navaid->getVorSlavedVariation());
    }
}
