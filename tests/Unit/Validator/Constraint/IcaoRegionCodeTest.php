<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\IcaoRegionCode;
use App\Validator\IcaoRegionCodeValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\IcaoRegionCode
 */
final class IcaoRegionCodeTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $icaoRegionCode = new IcaoRegionCode();

        self::assertEquals(IcaoRegionCodeValidator::class, $icaoRegionCode->validatedBy());
    }
}
