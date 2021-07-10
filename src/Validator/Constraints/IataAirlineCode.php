<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\IataAirlineCodeValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class IataAirlineCode extends Constraint
{
    public const NOT_VALID = '690af87f-eeaa-4a05-8cb2-422d4c1d9ab6';

    public string $message = 'This value should be a valid IATA airline code.';

    public function validatedBy(): string
    {
        return IataAirlineCodeValidator::class;
    }
}
