<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\IcaoAirportCodeValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class IcaoAirportCode extends Constraint
{
    public const NOT_VALID = '074f30e3-426f-4f27-b0f7-983a5186a76c';

    public string $message = 'This value should be a valid ICAO airport code.';

    public function validatedBy(): string
    {
        return IcaoAirportCodeValidator::class;
    }
}
