<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\Icao24bitAddress;
use App\Validator\Icao24bitAddressValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\Icao24bitAddress
 */
final class Icao24bitAddressTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $icao24bitAddress = new Icao24bitAddress();

        self::assertEquals(Icao24bitAddressValidator::class, $icao24bitAddress->validatedBy());
    }
}
