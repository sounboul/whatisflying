<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\LongitudeValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class Longitude extends Constraint
{
    public const NOT_VALID = 'e9b7f4bf-d292-4b70-834e-ceee7df6aa9c';

    public string $message = 'This value should be a valid longitude.';

    public function validatedBy(): string
    {
        return LongitudeValidator::class;
    }
}
