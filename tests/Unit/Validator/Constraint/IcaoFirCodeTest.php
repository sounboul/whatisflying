<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\IcaoFirCode;
use App\Validator\IcaoFirCodeValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\IcaoFirCode
 */
final class IcaoFirCodeTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $icaoFirCode = new IcaoFirCode();

        self::assertEquals(IcaoFirCodeValidator::class, $icaoFirCode->validatedBy());
    }
}
