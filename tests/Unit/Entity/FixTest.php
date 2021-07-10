<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Airport;
use App\Entity\Fix;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Fix
 */
final class FixTest extends TestCase
{
    /**
     * @testdox Sets/gets the airport to which the fix is associated.
     */
    public function testAirport(): void
    {
        $airport = $this
            ->getMockBuilder(Airport::class)
            ->getMock();

        $fix = new Fix();
        $fix->setAirport($airport);

        self::assertEquals($airport, $fix->getAirport());
    }

    /**
     * @testdox Sets/gets the fix identifier.
     */
    public function testIdentifier(): void
    {
        $fix = new Fix();
        $fix->setIdentifier('ABLIS');

        self::assertEquals('ABLIS', $fix->getIdentifier());
    }

    /**
     * @testdox Sets/gets the fix latitude.
     */
    public function testLatitude(): void
    {
        $fix = new Fix();
        $fix->setLatitude(44.064944444);

        self::assertEquals(44.064944444, $fix->getLatitude());
    }

    /**
     * @testdox Sets/gets the fix longitude.
     */
    public function testLongitude(): void
    {
        $fix = new Fix();
        $fix->setLongitude(1.481805556);

        self::assertEquals(1.481805556, $fix->getLongitude());
    }

    /**
     * @testdox Sets/gets the ICAO region to which the fix belongs.
     */
    public function testRegion(): void
    {
        $fix = new Fix();
        $fix->setRegion('LF');

        self::assertEquals('LF', $fix->getRegion());
    }

    /**
     * @testdox Sets/gets the fix slug.
     */
    public function testSlug(): void
    {
        $fix = new Fix();
        $fix->setSlug('ablis-lf-lfbo');

        self::assertEquals('ablis-lf-lfbo', $fix->getSlug());
    }

    /**
     * @testdox Sets/gets the fix usage type.
     */
    public function testUsage(): void
    {
        $fix = new Fix();
        $fix->setUsage('TERMINAL');

        self::assertEquals('TERMINAL', $fix->getUsage());
    }
}
