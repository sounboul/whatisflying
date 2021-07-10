<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\IataAircraftTypeCodeValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class IataAircraftTypeCode extends Constraint
{
    public const NOT_VALID = '8a855848-b5bd-483f-b398-ee099f03c20c';

    public string $message = 'This value should be a valid IATA aircraft type code.';

    public function validatedBy(): string
    {
        return IataAircraftTypeCodeValidator::class;
    }
}
