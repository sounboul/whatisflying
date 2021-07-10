<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\IataAirlineCode;
use App\Validator\IataAirlineCodeValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\IataAirlineCode
 */
final class IataAirlineCodeTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $iataAirlineCode = new IataAirlineCode();

        self::assertEquals(IataAirlineCodeValidator::class, $iataAirlineCode->validatedBy());
    }
}
