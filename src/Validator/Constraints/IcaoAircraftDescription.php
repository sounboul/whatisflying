<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\IcaoAircraftDescriptionValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class IcaoAircraftDescription extends Constraint
{
    public const NOT_VALID = '0fe4ad61-ac53-4afa-a87a-5f8ffbdaacd2';

    public string $message = 'This value should be a valid ICAO aircraft description.';

    public function validatedBy(): string
    {
        return IcaoAircraftDescriptionValidator::class;
    }
}
