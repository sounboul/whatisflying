<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\IcaoFirCodeValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class IcaoFirCode extends Constraint
{
    public const NOT_VALID = 'c32ffe60-5798-465e-9dc2-40e9a5f3595b';

    public string $message = 'This value should be a valid ICAO FIR code.';

    public function validatedBy(): string
    {
        return IcaoFirCodeValidator::class;
    }
}
