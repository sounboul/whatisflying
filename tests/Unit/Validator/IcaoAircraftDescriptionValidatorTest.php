<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use App\Validator\Constraints\IcaoAircraftDescription;
use App\Validator\IcaoAircraftDescriptionValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @covers \App\Validator\IcaoAircraftDescriptionValidator
 */
final class IcaoAircraftDescriptionValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * @testdox Passes validation when a valid value is provided.
     */
    public function testPassOnValidValue(): void
    {
        $constraint = new IcaoAircraftDescription();
        $validator = $this->getValidator(IcaoAircraftDescriptionValidator::class);

        $this->expectNoValidationError();
        $validator->validate('L1P', $constraint);
        $validator->validate('H2T', $constraint);
        $validator->validate('L12E', $constraint);
    }

    /**
     * @testdox Passes validation when a null value is provided.
     */
    public function testPassOnNullValue(): void
    {
        $constraint = new IcaoAircraftDescription();
        $validator = $this->getValidator(IcaoAircraftDescriptionValidator::class);

        $this->expectNoValidationError();
        $validator->validate(null, $constraint);
    }

    /**
     * @testdox Fails validation when an invalid value is provided.
     */
    public function testFailOnInvalidValue(): void
    {
        $constraint = new IcaoAircraftDescription();
        $validator = $this->getValidator(IcaoAircraftDescriptionValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('LAP', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('52J', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('L14', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('LL1P', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('L1PP', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('l1p', $constraint);
    }

    /**
     * @testdox Fails validation when an empty value is provided.
     */
    public function testFailOnEmptyValue(): void
    {
        $constraint = new IcaoAircraftDescription();
        $validator = $this->getValidator(IcaoAircraftDescriptionValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('', $constraint);
    }

    /**
     * @testdox Throws when an unexpected constraint is provided.
     */
    public function testThrowOnUnexpectedType(): void
    {
        $constraint = new NotNull();
        $validator = $this->getValidator(IcaoAircraftDescriptionValidator::class);

        $this->expectException(UnexpectedTypeException::class);
        $validator->validate('L1P', $constraint);
    }

    /**
     * @testdox Throws when an unexpected data type is provided.
     */
    public function testThrowOnUnexpectedValue(): void
    {
        $constraint = new IcaoAircraftDescription();
        $validator = $this->getValidator(IcaoAircraftDescriptionValidator::class);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate(42, $constraint);
    }
}
