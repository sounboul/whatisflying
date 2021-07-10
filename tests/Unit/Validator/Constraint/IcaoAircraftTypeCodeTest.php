<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\IcaoAircraftTypeCode;
use App\Validator\IcaoAircraftTypeCodeValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\IcaoAircraftTypeCode
 */
final class IcaoAircraftTypeCodeTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $icaoAircraftTypeCode = new IcaoAircraftTypeCode();

        self::assertEquals(IcaoAircraftTypeCodeValidator::class, $icaoAircraftTypeCode->validatedBy());
    }
}
