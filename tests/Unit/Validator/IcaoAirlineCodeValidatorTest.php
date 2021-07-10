<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use App\Validator\Constraints\IcaoAirlineCode;
use App\Validator\IcaoAirlineCodeValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @covers \App\Validator\IcaoAirlineCodeValidator
 */
final class IcaoAirlineCodeValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * @testdox Passes validation when a valid value is provided.
     */
    public function testPassOnValidValue(): void
    {
        $constraint = new IcaoAirlineCode();
        $validator = $this->getValidator(IcaoAirlineCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate('AFR', $constraint);
    }

    /**
     * @testdox Passes validation when a null value is provided.
     */
    public function testPassOnNullValue(): void
    {
        $constraint = new IcaoAirlineCode();
        $validator = $this->getValidator(IcaoAirlineCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate(null, $constraint);
    }

    /**
     * @testdox Fails validation when an invalid value is provided.
     */
    public function testFailOnInvalidValue(): void
    {
        $constraint = new IcaoAirlineCode();
        $validator = $this->getValidator(IcaoAirlineCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('AF', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('AFRA', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('afr', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('AF2', $constraint);
    }

    /**
     * @testdox Fails validation when an empty value is provided.
     */
    public function testFailOnEmptyValue(): void
    {
        $constraint = new IcaoAirlineCode();
        $validator = $this->getValidator(IcaoAirlineCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('', $constraint);
    }

    /**
     * @testdox Throws when an unexpected constraint is provided.
     */
    public function testThrowOnUnexpectedType(): void
    {
        $constraint = new NotNull();
        $validator = $this->getValidator(IcaoAirlineCodeValidator::class);

        $this->expectException(UnexpectedTypeException::class);
        $validator->validate('AFR', $constraint);
    }

    /**
     * @testdox Throws when an unexpected data type is provided.
     */
    public function testThrowOnUnexpectedValue(): void
    {
        $constraint = new IcaoAirlineCode();
        $validator = $this->getValidator(IcaoAirlineCodeValidator::class);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate(42, $constraint);
    }
}
