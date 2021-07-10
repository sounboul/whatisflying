<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\MagneticHeading;
use App\Validator\MagneticHeadingValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\MagneticHeading
 */
final class MagneticHeadingTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $magneticHeading = new MagneticHeading();

        self::assertEquals(MagneticHeadingValidator::class, $magneticHeading->validatedBy());
    }
}
