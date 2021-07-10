<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\Continent;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class ContinentValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof Continent) {
            throw new UnexpectedTypeException($constraint, Continent::class);
        }

        if (is_null($value)) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match('/^(AF|AN|AS|EU|NA|OC|SA)$/', $value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setCode(Continent::NOT_VALID)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
