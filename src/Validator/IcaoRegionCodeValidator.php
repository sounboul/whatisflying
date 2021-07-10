<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\IcaoRegionCode;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class IcaoRegionCodeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof IcaoRegionCode) {
            throw new UnexpectedTypeException($constraint, IcaoRegionCode::class);
        }

        if (is_null($value)) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match('/^(([A-Z][A-Z0-9])|P)$/', $value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setCode(IcaoRegionCode::NOT_VALID)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
