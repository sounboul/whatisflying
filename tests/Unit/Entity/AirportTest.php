<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Airport;
use App\Entity\AirportDataset;
use App\Entity\AirportFrequency;
use App\Entity\AirportRunway;
use App\Entity\Fir;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Airport
 */
final class AirportTest extends TestCase
{
    /**
     * @testdox Sets/gets whether the airport is active.
     */
    public function testActive(): void
    {
        $airport = new Airport();
        $airport->setActive(true);

        self::assertEquals(true, $airport->isActive());
    }

    /**
     * @testdox Sets/gets the continent where the airport is located.
     */
    public function testContinent(): void
    {
        $airport = new Airport();
        $airport->setContinent('EU');

        self::assertEquals('EU', $airport->getContinent());
    }

    /**
     * @testdox Sets/gets the country where the airport is located.
     */
    public function testCountry(): void
    {
        $airport = new Airport();
        $airport->setCountry('FR');

        self::assertEquals('FR', $airport->getCountry());
    }

    /**
     * @testdox Sets/gets the datasets that applies to the airport.
     */
    public function testDatasets(): void
    {
        $datasets = $this
            ->getMockBuilder(ArrayCollection::class)
            ->getMock();

        $airport = new Airport();
        $airport->setDatasets($datasets);

        self::assertEquals($datasets, $airport->getDatasets());

        $firstDataset = $this
            ->getMockBuilder(AirportDataset::class)
            ->getMock();

        $secondDataset = $this
            ->getMockBuilder(AirportDataset::class)
            ->getMock();

        $airport = new Airport();
        $airport->addDataset($firstDataset);
        $airport->addDataset($secondDataset);
        $airport->addDataset($secondDataset);

        self::assertCount(2, $airport->getDatasets());

        $airport->removeDataset($firstDataset);

        self::assertCount(1, $airport->getDatasets());
    }

    /**
     * @testdox Sets/gets the airport elevation.
     */
    public function testElevation(): void
    {
        $airport = new Airport();
        $airport->setElevation(482);

        self::assertEquals(482, $airport->getElevation());
    }

    /**
     * @testdox Sets/gets the flight information region to which the airport belongs.
     */
    public function testFir(): void
    {
        $fir = $this
            ->getMockBuilder(Fir::class)
            ->getMock();

        $airport = new Airport();
        $airport->setFir($fir);

        self::assertEquals($fir, $airport->getFir());
    }

    /**
     * @testdox Sets/gets the radio frequencies that belongs to the airport.
     */
    public function testFrequencies(): void
    {
        $frequencies = $this
            ->getMockBuilder(ArrayCollection::class)
            ->getMock();

        $airport = new Airport();
        $airport->setFrequencies($frequencies);

        self::assertEquals($frequencies, $airport->getFrequencies());

        $firstFrequency = $this
            ->getMockBuilder(AirportFrequency::class)
            ->getMock();

        $secondFrequency = $this
            ->getMockBuilder(AirportFrequency::class)
            ->getMock();

        $airport = new Airport();
        $airport->addFrequency($firstFrequency);
        $airport->addFrequency($secondFrequency);
        $airport->addFrequency($secondFrequency);

        self::assertCount(2, $airport->getFrequencies());

        $airport->removeFrequency($firstFrequency);

        self::assertCount(1, $airport->getFrequencies());
    }

    /**
     * @testdox Sets/gets the airport IATA code.
     */
    public function testIataCode(): void
    {
        $airport = new Airport();
        $airport->setIataCode('TLS');

        self::assertEquals('TLS', $airport->getIataCode());
    }

    /**
     * @testdox Sets/gets the airport ICAO code.
     */
    public function testIcaoCode(): void
    {
        $airport = new Airport();
        $airport->setIcaoCode('LFBO');

        self::assertEquals('LFBO', $airport->getIcaoCode());
    }

    /**
     * @testdox Sets/gets whether the airport is international.
     */
    public function testInternational(): void
    {
        $airport = new Airport();
        $airport->setInternational(true);

        self::assertEquals(true, $airport->isInternational());
    }

    /**
     * @testdox Sets/gets the airport latitude.
     */
    public function testLatitude(): void
    {
        $airport = new Airport();
        $airport->setLatitude(43.635);

        self::assertEquals(43.635, $airport->getLatitude());
    }

    /**
     * @testdox Sets/gets the airport longitude.
     */
    public function testLongitude(): void
    {
        $airport = new Airport();
        $airport->setLongitude(1.36778);

        self::assertEquals(1.36778, $airport->getLongitude());
    }

    /**
     * @testdox Sets/gets the airport name.
     */
    public function testName(): void
    {
        $airport = new Airport();
        $airport->setName('Toulouse-Blagnac Airport');

        self::assertEquals('Toulouse-Blagnac Airport', $airport->getName());
    }

    /**
     * @testdox Sets/gets the runways that belongs to the airport.
     */
    public function testRunways(): void
    {
        $runways = $this
            ->getMockBuilder(ArrayCollection::class)
            ->getMock();

        $airport = new Airport();
        $airport->setRunways($runways);

        self::assertEquals($runways, $airport->getRunways());

        $firstRunway = $this
            ->getMockBuilder(AirportRunway::class)
            ->getMock();

        $secondRunway = $this
            ->getMockBuilder(AirportRunway::class)
            ->getMock();

        $airport = new Airport();
        $airport->addRunway($firstRunway);
        $airport->addRunway($secondRunway);
        $airport->addRunway($secondRunway);

        self::assertCount(2, $airport->getRunways());

        $airport->removeRunway($firstRunway);

        self::assertCount(1, $airport->getRunways());
    }

    /**
     * @testdox Sets/gets the airport type.
     */
    public function testType(): void
    {
        $airport = new Airport();
        $airport->setType('large');

        self::assertEquals('large', $airport->getType());
    }
}
