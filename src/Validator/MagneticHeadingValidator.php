<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\MagneticHeading;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class MagneticHeadingValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof MagneticHeading) {
            throw new UnexpectedTypeException($constraint, MagneticHeading::class);
        }

        if (is_null($value)) {
            return;
        }

        if (!is_float($value)) {
            throw new UnexpectedValueException($value, 'float');
        }

        if ($value < 0 or $value > 360) {
            $this->context
                ->buildViolation($constraint->message)
                ->setCode(MagneticHeading::NOT_VALID)
                ->setParameter('{{ value }}', (string)$value)
                ->addViolation();
        }
    }
}
