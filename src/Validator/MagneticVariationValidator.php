<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\MagneticVariation;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class MagneticVariationValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof MagneticVariation) {
            throw new UnexpectedTypeException($constraint, MagneticVariation::class);
        }

        if (is_null($value)) {
            return;
        }

        if (!is_float($value)) {
            throw new UnexpectedValueException($value, 'float');
        }

        if ($value < -90 or $value > 90) {
            $this->context
                ->buildViolation($constraint->message)
                ->setCode(MagneticVariation::NOT_VALID)
                ->setParameter('{{ value }}', (string)$value)
                ->addViolation();
        }
    }
}
