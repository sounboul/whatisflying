<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\IcaoAircraftDescription;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class IcaoAircraftDescriptionValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof IcaoAircraftDescription) {
            throw new UnexpectedTypeException($constraint, IcaoAircraftDescription::class);
        }

        if (is_null($value)) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match('/^[AGHLT][0-9]+[EPJT]$/', $value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setCode(IcaoAircraftDescription::NOT_VALID)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
