<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\Icao24bitAddress;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class Icao24bitAddressValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof Icao24bitAddress) {
            throw new UnexpectedTypeException($constraint, Icao24bitAddress::class);
        }

        if (is_null($value)) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match('/^[a-f0-9]{6}$/', $value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setCode(Icao24bitAddress::NOT_VALID)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
