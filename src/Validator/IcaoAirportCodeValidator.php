<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\IcaoAirportCode;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class IcaoAirportCodeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof IcaoAirportCode) {
            throw new UnexpectedTypeException($constraint, IcaoAirportCode::class);
        }

        if (is_null($value)) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match('/^[A-Z]{4}$/', $value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setCode(IcaoAirportCode::NOT_VALID)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
