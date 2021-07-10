<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Constraint;

use App\Validator\Constraints\NavaidType;
use App\Validator\NavaidTypeValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Validator\Constraints\NavaidType
 */
final class NavaidTypeTest extends TestCase
{
    /**
     * @testdox Method validatedBy() returns the validator class.
     */
    public function testValidatedBy(): void
    {
        $navaidType = new NavaidType();

        self::assertEquals(NavaidTypeValidator::class, $navaidType->validatedBy());
    }
}
