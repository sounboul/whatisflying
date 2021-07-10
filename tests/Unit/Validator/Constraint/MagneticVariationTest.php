<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\MagneticVariation;
use App\Validator\MagneticVariationValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\MagneticVariation
 */
final class MagneticVariationTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $magneticVariation = new MagneticVariation();

        self::assertEquals(MagneticVariationValidator::class, $magneticVariation->validatedBy());
    }
}
