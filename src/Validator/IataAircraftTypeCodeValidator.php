<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\IataAircraftTypeCode;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class IataAircraftTypeCodeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof IataAircraftTypeCode) {
            throw new UnexpectedTypeException($constraint, IataAircraftTypeCode::class);
        }

        if (is_null($value)) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match('/^[A-Z0-9]{3}$/', $value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setCode(IataAircraftTypeCode::NOT_VALID)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
