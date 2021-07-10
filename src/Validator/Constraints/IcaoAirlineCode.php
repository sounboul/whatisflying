<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\IcaoAirlineCodeValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class IcaoAirlineCode extends Constraint
{
    public const NOT_VALID = '1770f65b-6178-4089-a79a-685565639d9e';

    public string $message = 'This value should be a valid ICAO airline code.';

    public function validatedBy(): string
    {
        return IcaoAirlineCodeValidator::class;
    }
}
