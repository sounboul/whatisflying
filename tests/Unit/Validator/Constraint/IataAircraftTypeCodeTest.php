<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\IataAircraftTypeCode;
use App\Validator\IataAircraftTypeCodeValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\IataAircraftTypeCode
 */
final class IataAircraftTypeCodeTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $iataAircraftTypeCode = new IataAircraftTypeCode();

        self::assertEquals(IataAircraftTypeCodeValidator::class, $iataAircraftTypeCode->validatedBy());
    }
}
