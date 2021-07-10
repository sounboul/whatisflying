<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use App\Validator\Constraints\Latitude;
use App\Validator\LatitudeValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @covers \App\Validator\LatitudeValidator
 */
final class LatitudeValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * @testdox Passes validation when a valid value is provided.
     */
    public function testPassOnValidValue(): void
    {
        $constraint = new Latitude();
        $validator = $this->getValidator(LatitudeValidator::class);

        $this->expectNoValidationError();
        $validator->validate(-90.0, $constraint);
        $validator->validate(0.0, $constraint);
        $validator->validate(90.0, $constraint);
    }

    /**
     * @testdox Passes validation when a null value is provided.
     */
    public function testPassOnNullValue(): void
    {
        $constraint = new Latitude();
        $validator = $this->getValidator(LatitudeValidator::class);

        $this->expectNoValidationError();
        $validator->validate(null, $constraint);
    }

    /**
     * @testdox Fails validation when an invalid value is provided.
     */
    public function testFailOnInvalidValue(): void
    {
        $constraint = new Latitude();
        $validator = $this->getValidator(LatitudeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate(91.0, $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate(-91.0, $constraint);
    }

    /**
     * @testdox Throws when an unexpected constraint is provided.
     */
    public function testThrowOnUnexpectedType(): void
    {
        $constraint = new NotNull();
        $validator = $this->getValidator(LatitudeValidator::class);

        $this->expectException(UnexpectedTypeException::class);
        $validator->validate(0.0, $constraint);
    }

    /**
     * @testdox Throws when an unexpected data type is provided.
     */
    public function testThrowOnUnexpectedValue(): void
    {
        $constraint = new Latitude();
        $validator = $this->getValidator(LatitudeValidator::class);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate('0.0', $constraint);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate(0, $constraint);
    }
}
