<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\License;
use Composer\Spdx\SpdxLicenses;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class LicenseValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof License) {
            throw new UnexpectedTypeException($constraint, License::class);
        }

        if (is_null($value)) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $spdx = new SpdxLicenses();

        if (!$spdx->validate($value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setCode(License::NOT_VALID)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
