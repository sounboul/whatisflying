<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\IataAirportCodeValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class IataAirportCode extends Constraint
{
    public const NOT_VALID = '9b5978e4-dc2c-4f43-9e2c-266679d8d4ae';

    public string $message = 'This value should be a valid IATA airport code.';

    public function validatedBy(): string
    {
        return IataAirportCodeValidator::class;
    }
}
