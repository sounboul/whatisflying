<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\NavaidType;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class NavaidTypeValidator extends ConstraintValidator
{
    public const NAVAID_TYPES = [
        'DME',
        'DME-ILS',
        'DME-NDB',
        'GS',
        'IGS',
        'ILS-I',
        'ILS-II',
        'ILS-III',
        'IM',
        'LDA',
        'LOC',
        'MM',
        'NDB',
        'OM',
        'SDF',
        'TACAN',
        'VOR',
        'VOR-DME',
        'VORTAC',
    ];

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof NavaidType) {
            throw new UnexpectedTypeException($constraint, NavaidType::class);
        }

        if (is_null($value)) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!in_array($value, self::NAVAID_TYPES, true)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setCode(NavaidType::NOT_VALID)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
