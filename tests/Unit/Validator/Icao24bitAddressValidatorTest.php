<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use App\Validator\Constraints\Icao24bitAddress;
use App\Validator\Icao24bitAddressValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @covers \App\Validator\Icao24bitAddressValidator
 */
final class Icao24bitAddressValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * @testdox Passes validation when a valid value is provided.
     */
    public function testPassOnValidValue(): void
    {
        $constraint = new Icao24bitAddress();
        $validator = $this->getValidator(Icao24bitAddressValidator::class);

        $this->expectNoValidationError();
        $validator->validate('c0ffee', $constraint);
        $validator->validate('123456', $constraint);
        $validator->validate('abcdef', $constraint);
    }

    /**
     * @testdox Passes validation when a null value is provided.
     */
    public function testPassOnNullValue(): void
    {
        $constraint = new Icao24bitAddress();
        $validator = $this->getValidator(Icao24bitAddressValidator::class);

        $this->expectNoValidationError();
        $validator->validate(null, $constraint);
    }

    /**
     * @testdox Fails validation when an invalid value is provided.
     */
    public function testFailOnInvalidValue(): void
    {
        $constraint = new Icao24bitAddress();
        $validator = $this->getValidator(Icao24bitAddressValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('c0ff', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('c0ffeeab', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('C0FFEE', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('c0zfee', $constraint);
    }

    /**
     * @testdox Fails validation when an empty value is provided.
     */
    public function testFailOnEmptyValue(): void
    {
        $constraint = new Icao24bitAddress();
        $validator = $this->getValidator(Icao24bitAddressValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('', $constraint);
    }

    /**
     * @testdox Throws when an unexpected constraint is provided.
     */
    public function testThrowOnUnexpectedType(): void
    {
        $constraint = new NotNull();
        $validator = $this->getValidator(Icao24bitAddressValidator::class);

        $this->expectException(UnexpectedTypeException::class);
        $validator->validate('c0ffee', $constraint);
    }

    /**
     * @testdox Throws when an unexpected data type is provided.
     */
    public function testThrowOnUnexpectedValue(): void
    {
        $constraint = new Icao24bitAddress();
        $validator = $this->getValidator(Icao24bitAddressValidator::class);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate(42, $constraint);
    }
}
