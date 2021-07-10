<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\LatitudeValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class Latitude extends Constraint
{
    public const NOT_VALID = 'eed40844-2512-4856-b358-ef30d4406241';

    public string $message = 'This value should be a valid latitude.';

    public function validatedBy(): string
    {
        return LatitudeValidator::class;
    }
}
