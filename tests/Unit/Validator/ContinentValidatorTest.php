<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use App\Validator\Constraints\Continent;
use App\Validator\ContinentValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @covers \App\Validator\ContinentValidator
 */
final class ContinentValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * @testdox Passes validation when a valid value is provided.
     */
    public function testPassOnValidValue(): void
    {
        $constraint = new Continent();
        $validator = $this->getValidator(ContinentValidator::class);

        $this->expectNoValidationError();
        $validator->validate('AF', $constraint);
        $validator->validate('AN', $constraint);
        $validator->validate('AS', $constraint);
        $validator->validate('EU', $constraint);
        $validator->validate('NA', $constraint);
        $validator->validate('OC', $constraint);
        $validator->validate('SA', $constraint);
    }

    /**
     * @testdox Passes validation when a null value is provided.
     */
    public function testPassOnNullValue(): void
    {
        $constraint = new Continent();
        $validator = $this->getValidator(ContinentValidator::class);

        $this->expectNoValidationError();
        $validator->validate(null, $constraint);
    }

    /**
     * @testdox Fails validation when an invalid value is provided.
     */
    public function testFailOnInvalidValue(): void
    {
        $constraint = new Continent();
        $validator = $this->getValidator(ContinentValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('NO', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('EUU', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('eu', $constraint);
    }

    /**
     * @testdox Fails validation when an empty value is provided.
     */
    public function testFailOnEmptyValue(): void
    {
        $constraint = new Continent();
        $validator = $this->getValidator(ContinentValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('', $constraint);
    }

    /**
     * @testdox Throws when an unexpected constraint is provided.
     */
    public function testThrowOnUnexpectedType(): void
    {
        $constraint = new NotNull();
        $validator = $this->getValidator(ContinentValidator::class);

        $this->expectException(UnexpectedTypeException::class);
        $validator->validate('EU', $constraint);
    }

    /**
     * @testdox Throws when an unexpected data type is provided.
     */
    public function testThrowOnUnexpectedValue(): void
    {
        $constraint = new Continent();
        $validator = $this->getValidator(ContinentValidator::class);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate(42, $constraint);
    }
}
