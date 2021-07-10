<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\Longitude;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class LongitudeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof Longitude) {
            throw new UnexpectedTypeException($constraint, Longitude::class);
        }

        if (is_null($value)) {
            return;
        }

        if (!is_float($value)) {
            throw new UnexpectedValueException($value, 'float');
        }

        if ($value < -180 or $value > 180) {
            $this->context
                ->buildViolation($constraint->message)
                ->setCode(Longitude::NOT_VALID)
                ->setParameter('{{ value }}', (string)$value)
                ->addViolation();
        }
    }
}
