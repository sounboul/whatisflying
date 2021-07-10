<?php

declare(strict_types=1);

namespace Tests\Unit\Util;

use App\Util\Icao24bitAddress;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Intl\Countries;

/**
 * @covers \App\Util\Icao24bitAddress
 */
final class Icao24bitAddressTest extends TestCase
{
    /**
     * @testdox Method getRegistrationCountry() returns the country code or null if not found.
     */
    public function testReturnCountryOrNull(): void
    {
        self::assertEquals('FR', Icao24bitAddress::getRegistrationCountry('38ad9f'));
        self::assertEquals(null, Icao24bitAddress::getRegistrationCountry('ffffff'));
    }

    /**
     * @testdox Method getRegistrationCountry() returns only valid country codes.
     */
    public function testReturnValidCountryCodes(): void
    {
        for ($i = 0x000000; $i <= 0xffffff; $i += 1000) {
            if (!is_null($country = Icao24bitAddress::getRegistrationCountry(sprintf('%08x', $i)))) {
                self::assertEquals(true, Countries::exists($country));
            }
        }
    }

    /**
     * @testdox Method getRegistrationCountry() throws when an invalid argument is provided.
     */
    public function testThrowOnInvalidArgument(): void
    {
        self::expectException(\InvalidArgumentException::class);
        Icao24bitAddress::getRegistrationCountry('not_an_icao_24_bit_address');
    }
}
