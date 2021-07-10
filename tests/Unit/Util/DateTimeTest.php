<?php

declare(strict_types=1);

namespace Tests\Unit\Util;

use App\Util\DateTime;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Util\DateTime
 */
final class DateTimeTest extends TestCase
{
    /**
     * @testdox Method getCurrentUtc() returns the current date & time in UTC.
     */
    public function testGetCurrentUtc(): void
    {
        $dateTime = DateTime::getCurrentUtc();

        self::assertEquals('UTC', $dateTime->getTimezone()->getName());
    }
}
