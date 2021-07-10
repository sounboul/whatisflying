<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\Icao24bitAddressValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class Icao24bitAddress extends Constraint
{
    public const NOT_VALID = 'f28b18f7-2087-4ced-9512-c08716d31c4c';

    public string $message = 'This value should be a valid ICAO 24-bit address.';

    public function validatedBy(): string
    {
        return Icao24bitAddressValidator::class;
    }
}
