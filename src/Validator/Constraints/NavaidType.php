<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\NavaidTypeValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class NavaidType extends Constraint
{
    public const NOT_VALID = 'd92823ad-fdd8-49f6-996b-dd16fc13408d';

    public string $message = 'This value should be a valid navaid type code.';

    public function validatedBy(): string
    {
        return NavaidTypeValidator::class;
    }
}
