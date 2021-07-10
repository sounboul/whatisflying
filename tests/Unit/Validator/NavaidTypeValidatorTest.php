<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use App\Validator\Constraints\NavaidType;
use App\Validator\NavaidTypeValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @covers \App\Validator\NavaidTypeValidator
 */
final class NavaidTypeValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * @testdox Passes validation when a valid value is provided.
     */
    public function testPassOnValidValue(): void
    {
        $constraint = new NavaidType();
        $validator = $this->getValidator(NavaidTypeValidator::class);

        $this->expectNoValidationError();
        $validator->validate('DME', $constraint);
        $validator->validate('DME-ILS', $constraint);
        $validator->validate('GS', $constraint);
        $validator->validate('IGS', $constraint);
        $validator->validate('ILS-I', $constraint);
        $validator->validate('ILS-II', $constraint);
        $validator->validate('ILS-III', $constraint);
        $validator->validate('LDA', $constraint);
        $validator->validate('LOC', $constraint);
        $validator->validate('NDB', $constraint);
        $validator->validate('SDF', $constraint);
        $validator->validate('TACAN', $constraint);
        $validator->validate('VOR', $constraint);
        $validator->validate('VOR-DME', $constraint);
        $validator->validate('VORTAC', $constraint);
    }

    /**
     * @testdox Passes validation when a null value is provided.
     */
    public function testPassOnNullValue(): void
    {
        $constraint = new NavaidType();
        $validator = $this->getValidator(NavaidTypeValidator::class);

        $this->expectNoValidationError();
        $validator->validate(null, $constraint);
    }

    /**
     * @testdox Fails validation when an invalid value is provided.
     */
    public function testFailOnInvalidValue(): void
    {
        $constraint = new NavaidType();
        $validator = $this->getValidator(NavaidTypeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('VORDME', $constraint);
    }

    /**
     * @testdox Fails validation when an empty value is provided.
     */
    public function testFailOnEmptyValue(): void
    {
        $constraint = new NavaidType();
        $validator = $this->getValidator(NavaidTypeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('', $constraint);
    }

    /**
     * @testdox Throws when an unexpected constraint is provided.
     */
    public function testThrowOnUnexpectedType(): void
    {
        $constraint = new NotNull();
        $validator = $this->getValidator(NavaidTypeValidator::class);

        $this->expectException(UnexpectedTypeException::class);
        $validator->validate('VOR-DME', $constraint);
    }

    /**
     * @testdox Throws when an unexpected data type is provided.
     */
    public function testThrowOnUnexpectedValue(): void
    {
        $constraint = new NavaidType();
        $validator = $this->getValidator(NavaidTypeValidator::class);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate(42, $constraint);
    }
}
