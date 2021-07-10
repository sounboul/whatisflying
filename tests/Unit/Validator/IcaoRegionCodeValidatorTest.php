<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use App\Validator\Constraints\IcaoRegionCode;
use App\Validator\IcaoRegionCodeValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @covers \App\Validator\IcaoRegionCodeValidator
 */
final class IcaoRegionCodeValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * @testdox Passes validation when a valid value is provided.
     */
    public function testPassOnValidValue(): void
    {
        $constraint = new IcaoRegionCode();
        $validator = $this->getValidator(IcaoRegionCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate('LF', $constraint);
        $validator->validate('L9', $constraint);
    }

    /**
     * @testdox Passes validation when a null value is provided.
     */
    public function testPassOnNullValue(): void
    {
        $constraint = new IcaoRegionCode();
        $validator = $this->getValidator(IcaoRegionCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate(null, $constraint);
    }

    /**
     * @testdox Fails validation when an invalid value is provided.
     */
    public function testFailOnInvalidValue(): void
    {
        $constraint = new IcaoRegionCode();
        $validator = $this->getValidator(IcaoRegionCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('L', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('LFF', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('lf', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('9L', $constraint);
    }

    /**
     * @testdox Fails validation when an empty value is provided.
     */
    public function testFailOnEmptyValue(): void
    {
        $constraint = new IcaoRegionCode();
        $validator = $this->getValidator(IcaoRegionCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('', $constraint);
    }

    /**
     * @testdox Throws when an unexpected constraint is provided.
     */
    public function testThrowOnUnexpectedType(): void
    {
        $constraint = new NotNull();
        $validator = $this->getValidator(IcaoRegionCodeValidator::class);

        $this->expectException(UnexpectedTypeException::class);
        $validator->validate('LF', $constraint);
    }

    /**
     * @testdox Throws when an unexpected data type is provided.
     */
    public function testThrowOnUnexpectedValue(): void
    {
        $constraint = new IcaoRegionCode();
        $validator = $this->getValidator(IcaoRegionCodeValidator::class);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate(42, $constraint);
    }
}
