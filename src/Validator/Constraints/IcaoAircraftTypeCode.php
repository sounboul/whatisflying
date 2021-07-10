<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\IcaoAircraftTypeCodeValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class IcaoAircraftTypeCode extends Constraint
{
    public const NOT_VALID = '0f29db7d-c19b-4094-bba5-d0d000ea2109';

    public string $message = 'This value should be a valid ICAO aircraft type code.';

    public function validatedBy(): string
    {
        return IcaoAircraftTypeCodeValidator::class;
    }
}
