<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use App\Validator\Constraints\IataAirportCode;
use App\Validator\IataAirportCodeValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @covers \App\Validator\IataAirportCodeValidator
 */
final class IataAirportCodeValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * @testdox Passes validation when a valid value is provided.
     */
    public function testPassOnValidValue(): void
    {
        $constraint = new IataAirportCode();
        $validator = $this->getValidator(IataAirportCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate('TOU', $constraint);
    }

    /**
     * @testdox Passes validation when a null value is provided.
     */
    public function testPassOnNullValue(): void
    {
        $constraint = new IataAirportCode();
        $validator = $this->getValidator(IataAirportCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate(null, $constraint);
    }

    /**
     * @testdox Fails validation when an invalid value is provided.
     */
    public function testFailOnInvalidValue(): void
    {
        $constraint = new IataAirportCode();
        $validator = $this->getValidator(IataAirportCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('TOUL', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('TO', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('TO2', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('tou', $constraint);
    }

    /**
     * @testdox Fails validation when an empty value is provided.
     */
    public function testFailOnEmptyValue(): void
    {
        $constraint = new IataAirportCode();
        $validator = $this->getValidator(IataAirportCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('', $constraint);
    }

    /**
     * @testdox Throws when an unexpected constraint is provided.
     */
    public function testThrowOnUnexpectedType(): void
    {
        $constraint = new NotNull();
        $validator = $this->getValidator(IataAirportCodeValidator::class);

        $this->expectException(UnexpectedTypeException::class);
        $validator->validate('AF', $constraint);
    }

    /**
     * @testdox Throws when an unexpected data type is provided.
     */
    public function testThrowOnUnexpectedValue(): void
    {
        $constraint = new IataAirportCode();
        $validator = $this->getValidator(IataAirportCodeValidator::class);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate(42, $constraint);
    }
}
