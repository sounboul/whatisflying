<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\Longitude;
use App\Validator\LongitudeValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\Longitude
 */
final class LongitudeTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $longitude = new Longitude();

        self::assertEquals(LongitudeValidator::class, $longitude->validatedBy());
    }
}
