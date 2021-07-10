<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use App\Validator\Constraints\IataAirlineCode;
use App\Validator\IataAirlineCodeValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @covers \App\Validator\IataAirlineCodeValidator
 */
final class IataAirlineCodeValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * @testdox Passes validation when a valid value is provided.
     */
    public function testPassOnValidValue(): void
    {
        $constraint = new IataAirlineCode();
        $validator = $this->getValidator(IataAirlineCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate('ZI', $constraint);
        $validator->validate('G4', $constraint);
        $validator->validate('9U', $constraint);
        $validator->validate('ED*', $constraint);
        $validator->validate('P7*', $constraint);
        $validator->validate('3B*', $constraint);
    }

    /**
     * @testdox Passes validation when a null value is provided.
     */
    public function testPassOnNullValue(): void
    {
        $constraint = new IataAirlineCode();
        $validator = $this->getValidator(IataAirlineCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate(null, $constraint);
    }

    /**
     * @testdox Fails validation when an invalid value is provided.
     */
    public function testFailOnInvalidValue(): void
    {
        $constraint = new IataAirlineCode();
        $validator = $this->getValidator(IataAirlineCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('ZIG', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('G', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('ED**', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('95', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('zi', $constraint);
    }

    /**
     * @testdox Fails validation when an empty value is provided.
     */
    public function testFailOnEmptyValue(): void
    {
        $constraint = new IataAirlineCode();
        $validator = $this->getValidator(IataAirlineCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('', $constraint);
    }

    /**
     * @testdox Throws when an unexpected constraint is provided.
     */
    public function testThrowOnUnexpectedType(): void
    {
        $constraint = new NotNull();
        $validator = $this->getValidator(IataAirlineCodeValidator::class);

        $this->expectException(UnexpectedTypeException::class);
        $validator->validate('ZI', $constraint);
    }

    /**
     * @testdox Throws when an unexpected data type is provided.
     */
    public function testThrowOnUnexpectedValue(): void
    {
        $constraint = new IataAirlineCode();
        $validator = $this->getValidator(IataAirlineCodeValidator::class);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate(42, $constraint);
    }
}
