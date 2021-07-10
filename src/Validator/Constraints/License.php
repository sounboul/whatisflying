<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\LicenseValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class License extends Constraint
{
    public const NOT_VALID = '733f987e-9ea6-4133-bb5c-73b2d64af7e2';

    public string $message = 'This value should be a valid SPDX license identifier.';

    public function validatedBy(): string
    {
        return LicenseValidator::class;
    }
}
