<?php

declare(strict_types=1);

namespace App\Util;

final class DateTime
{
    /**
     * Returns the current UTC date and time.
     *
     * @return \DateTime
     * @throws \Exception
     */
    public static function getCurrentUtc(): \DateTimeInterface
    {
        return new \DateTime('now', new \DateTimeZone('UTC'));
    }
}
