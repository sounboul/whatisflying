<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\ContinentValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class Continent extends Constraint
{
    public const NOT_VALID = 'dafa2928-e449-4375-9bab-4a63073d8dc4';

    public string $message = 'This value should be a valid 2 letter continent code.';

    public function validatedBy(): string
    {
        return ContinentValidator::class;
    }
}
