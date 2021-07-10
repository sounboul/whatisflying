<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\IcaoRegionCodeValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class IcaoRegionCode extends Constraint
{
    public const NOT_VALID = '884a9b95-24ce-4243-9a7b-1aace9e5f416';

    public string $message = 'This value should be a valid ICAO region code.';

    public function validatedBy(): string
    {
        return IcaoRegionCodeValidator::class;
    }
}
