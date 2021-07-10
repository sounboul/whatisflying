<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\IcaoAirlineCode;
use App\Validator\IcaoAirlineCodeValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\IcaoAirlineCode
 */
final class IcaoAirlineCodeTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $icaoAirlineCode = new IcaoAirlineCode();

        self::assertEquals(IcaoAirlineCodeValidator::class, $icaoAirlineCode->validatedBy());
    }
}
