<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\Continent;
use App\Validator\ContinentValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\Continent
 */
final class ContinentTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $continent = new Continent();

        self::assertEquals(ContinentValidator::class, $continent->validatedBy());
    }
}
