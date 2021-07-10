<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\IataAirlineCode;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class IataAirlineCodeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof IataAirlineCode) {
            throw new UnexpectedTypeException($constraint, IataAirlineCode::class);
        }

        if (is_null($value)) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match('/^([A-Z]{2}|([A-Z][0-9])|([0-9][A-Z]))\*?$/', $value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setCode(IataAirlineCode::NOT_VALID)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
