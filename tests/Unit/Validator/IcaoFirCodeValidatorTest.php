<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use App\Validator\Constraints\IcaoFirCode;
use App\Validator\IcaoFirCodeValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @covers \App\Validator\IcaoFirCodeValidator
 */
final class IcaoFirCodeValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * @testdox Passes validation when a valid value is provided.
     */
    public function testPassOnValidValue(): void
    {
        $constraint = new IcaoFirCode();
        $validator = $this->getValidator(IcaoFirCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate('LFBB', $constraint);
    }

    /**
     * @testdox Passes validation when a null value is provided.
     */
    public function testPassOnNullValue(): void
    {
        $constraint = new IcaoFirCode();
        $validator = $this->getValidator(IcaoFirCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate(null, $constraint);
    }

    /**
     * @testdox Fails validation when an invalid value is provided.
     */
    public function testFailOnInvalidValue(): void
    {
        $constraint = new IcaoFirCode();
        $validator = $this->getValidator(IcaoFirCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('LFB', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('LFBBB', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('lfbb', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('LFB1', $constraint);
    }

    /**
     * @testdox Fails validation when an empty value is provided.
     */
    public function testFailOnEmptyValue(): void
    {
        $constraint = new IcaoFirCode();
        $validator = $this->getValidator(IcaoFirCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('', $constraint);
    }

    /**
     * @testdox Throws when an unexpected constraint is provided.
     */
    public function testThrowOnUnexpectedType(): void
    {
        $constraint = new NotNull();
        $validator = $this->getValidator(IcaoFirCodeValidator::class);

        $this->expectException(UnexpectedTypeException::class);
        $validator->validate('LFBB', $constraint);
    }

    /**
     * @testdox Throws when an unexpected data type is provided.
     */
    public function testThrowOnUnexpectedValue(): void
    {
        $constraint = new IcaoFirCode();
        $validator = $this->getValidator(IcaoFirCodeValidator::class);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate(42, $constraint);
    }
}
