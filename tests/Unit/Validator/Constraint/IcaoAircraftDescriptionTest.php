<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\IcaoAircraftDescription;
use App\Validator\IcaoAircraftDescriptionValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\IcaoAircraftDescription
 */
final class IcaoAircraftDescriptionTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $icaoAircraftDescription = new IcaoAircraftDescription();

        self::assertEquals(IcaoAircraftDescriptionValidator::class, $icaoAircraftDescription->validatedBy());
    }
}
