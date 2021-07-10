<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use App\Validator\Constraints\IcaoAirportCode;
use App\Validator\IcaoAirportCodeValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @covers \App\Validator\IcaoAirportCodeValidator
 */
final class IcaoAirportCodeValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * @testdox Passes validation when a valid value is provided.
     */
    public function testPassOnValidValue(): void
    {
        $constraint = new IcaoAirportCode();
        $validator = $this->getValidator(IcaoAirportCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate('LFBO', $constraint);
    }

    /**
     * @testdox Passes validation when a null value is provided.
     */
    public function testPassOnNullValue(): void
    {
        $constraint = new IcaoAirportCode();
        $validator = $this->getValidator(IcaoAirportCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate(null, $constraint);
    }

    /**
     * @testdox Fails validation when an invalid value is provided.
     */
    public function testFailOnInvalidValue(): void
    {
        $constraint = new IcaoAirportCode();
        $validator = $this->getValidator(IcaoAirportCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('LFB', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('LFBOO', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('lfbo', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('LFB1', $constraint);
    }

    /**
     * @testdox Fails validation when an empty value is provided.
     */
    public function testFailOnEmptyValue(): void
    {
        $constraint = new IcaoAirportCode();
        $validator = $this->getValidator(IcaoAirportCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('', $constraint);
    }

    /**
     * @testdox Throws when an unexpected constraint is provided.
     */
    public function testThrowOnUnexpectedType(): void
    {
        $constraint = new NotNull();
        $validator = $this->getValidator(IcaoAirportCodeValidator::class);

        $this->expectException(UnexpectedTypeException::class);
        $validator->validate('LFBO', $constraint);
    }

    /**
     * @testdox Throws when an unexpected data type is provided.
     */
    public function testThrowOnUnexpectedValue(): void
    {
        $constraint = new IcaoAirportCode();
        $validator = $this->getValidator(IcaoAirportCodeValidator::class);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate(42, $constraint);
    }
}
