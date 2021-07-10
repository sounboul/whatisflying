<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\License;
use App\Validator\LicenseValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\License
 */
final class LicenseTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $license = new License();

        self::assertEquals(LicenseValidator::class, $license->validatedBy());
    }
}
