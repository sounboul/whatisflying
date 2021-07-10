<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\IcaoAircraftTypeCode;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class IcaoAircraftTypeCodeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof IcaoAircraftTypeCode) {
            throw new UnexpectedTypeException($constraint, IcaoAircraftTypeCode::class);
        }

        if (is_null($value)) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match('/^[A-Z0-9]{2,4}$/', $value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setCode(IcaoAircraftTypeCode::NOT_VALID)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
