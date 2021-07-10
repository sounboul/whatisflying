<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\Latitude;
use App\Validator\LatitudeValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\Latitude
 */
final class LatitudeTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $latitude = new Latitude();

        self::assertEquals(LatitudeValidator::class, $latitude->validatedBy());
    }
}
