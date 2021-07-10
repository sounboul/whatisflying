<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\Latitude;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class LatitudeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof Latitude) {
            throw new UnexpectedTypeException($constraint, Latitude::class);
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
                ->setCode(Latitude::NOT_VALID)
                ->setParameter('{{ value }}', (string)$value)
                ->addViolation();
        }
    }
}
