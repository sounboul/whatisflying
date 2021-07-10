<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\MagneticVariationValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class MagneticVariation extends Constraint
{
    public const NOT_VALID = 'f8c91e7f-e030-4bdf-a92d-223022adb066';

    public string $message = 'This value should be a valid magnetic variation.';

    public function validatedBy(): string
    {
        return MagneticVariationValidator::class;
    }
}
