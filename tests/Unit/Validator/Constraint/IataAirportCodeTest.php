<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\IataAirportCode;
use App\Validator\IataAirportCodeValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\IataAirportCode
 */
final class IataAirportCodeTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $iataAirportCode = new IataAirportCode();

        self::assertEquals(IataAirportCodeValidator::class, $iataAirportCode->validatedBy());
    }
}
