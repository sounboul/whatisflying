<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use App\Validator\Constraints\License;
use App\Validator\LicenseValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @covers \App\Validator\LicenseValidator
 */
final class LicenseValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * @testdox Passes validation when a valid value is provided.
     */
    public function testPassOnValidValue(): void
    {
        $constraint = new License();
        $validator = $this->getValidator(LicenseValidator::class);

        $this->expectNoValidationError();
        $validator->validate('CC-BY-SA-2.0', $constraint);
    }

    /**
     * @testdox Passes validation when a null value is provided.
     */
    public function testPassOnNullValue(): void
    {
        $constraint = new License();
        $validator = $this->getValidator(LicenseValidator::class);

        $this->expectNoValidationError();
        $validator->validate(null, $constraint);
    }

    /**
     * @testdox Fails validation when an invalid value is provided.
     */
    public function testFailOnInvalidValue(): void
    {
        $constraint = new License();
        $validator = $this->getValidator(LicenseValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('CCBYSA', $constraint);
    }

    /**
     * @testdox Fails validation when an empty value is provided.
     */
    public function testFailOnEmptyValue(): void
    {
        $constraint = new License();
        $validator = $this->getValidator(LicenseValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('', $constraint);
    }

    /**
     * @testdox Throws when an unexpected constraint is provided.
     */
    public function testThrowOnUnexpectedType(): void
    {
        $constraint = new NotNull();
        $validator = $this->getValidator(LicenseValidator::class);

        $this->expectException(UnexpectedTypeException::class);
        $validator->validate('CC-BY-SA-2.0', $constraint);
    }

    /**
     * @testdox Throws when an unexpected data type is provided.
     */
    public function testThrowOnUnexpectedValue(): void
    {
        $constraint = new License();
        $validator = $this->getValidator(LicenseValidator::class);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate(42, $constraint);
    }
}
