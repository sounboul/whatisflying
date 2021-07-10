<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\MagneticHeadingValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class MagneticHeading extends Constraint
{
    public const NOT_VALID = '81283648-d3e6-40c0-94c9-053af5db35c0';

    public string $message = 'This value should be a valid magnetic heading.';

    public function validatedBy(): string
    {
        return MagneticHeadingValidator::class;
    }
}
