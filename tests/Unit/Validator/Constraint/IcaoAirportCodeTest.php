<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\IcaoAirportCode;
use App\Validator\IcaoAirportCodeValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\IcaoAirportCode
 */
final class IcaoAirportCodeTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $icaoAirportCode = new IcaoAirportCode();

        self::assertEquals(IcaoAirportCodeValidator::class, $icaoAirportCode->validatedBy());
    }
}
