<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use App\Validator\Constraints\Longitude;
use App\Validator\LongitudeValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @covers \App\Validator\LongitudeValidator
 */
final class LongitudeValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * @testdox Passes validation when a valid value is provided.
     */
    public function testPassOnValidValue(): void
    {
        $constraint = new Longitude();
        $validator = $this->getValidator(LongitudeValidator::class);

        $this->expectNoValidationError();
        $validator->validate(-180.0, $constraint);
        $validator->validate(0.0, $constraint);
        $validator->validate(180.0, $constraint);
    }

    /**
     * @testdox Passes validation when a null value is provided.
     */
    public function testPassOnNullValue(): void
    {
        $constraint = new Longitude();
        $validator = $this->getValidator(LongitudeValidator::class);

        $this->expectNoValidationError();
        $validator->validate(null, $constraint);
    }

    /**
     * @testdox Fails validation when an invalid value is provided.
     */
    public function testFailOnInvalidValue(): void
    {
        $constraint = new Longitude();
        $validator = $this->getValidator(LongitudeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate(-181.0, $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate(181.0, $constraint);
    }

    /**
     * @testdox Throws when an unexpected constraint is provided.
     */
    public function testThrowOnUnexpectedType(): void
    {
        $constraint = new NotNull();
        $validator = $this->getValidator(LongitudeValidator::class);

        $this->expectException(UnexpectedTypeException::class);
        $validator->validate(0.0, $constraint);
    }

    /**
     * @testdox Throws when an unexpected data type is provided.
     */
    public function testThrowOnUnexpectedValue(): void
    {
        $constraint = new Longitude();
        $validator = $this->getValidator(LongitudeValidator::class);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate('0.0', $constraint);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate(0, $constraint);
    }
}
