<?php

declare(strict_types=1);

namespace Tests\Unit\Entity\Traits;

use App\Entity\Traits\TimestampableTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Traits\TimestampableTrait
 */
final class TimestampableTraitTest extends TestCase
{
    /**
     * @testdox Sets/gets the entity creation date and time.
     */
    public function testCreated(): void
    {
        $timestampable = $this
            ->getMockBuilder(TimestampableTrait::class)
            ->getMockForTrait();

        $created = $this
            ->getMockBuilder(\DateTime::class)
            ->getMock();

        $timestampable->setCreated($created);

        self::assertEquals($created, $timestampable->getCreated());
    }

    /**
     * @testdox Sets/gets the entity modification date and time.
     */
    public function testUpdated(): void
    {
        $timestampable = $this
            ->getMockBuilder(TimestampableTrait::class)
            ->getMockForTrait();

        $updated = $this
            ->getMockBuilder(\DateTime::class)
            ->getMock();

        $timestampable->setUpdated($updated);

        self::assertEquals($updated, $timestampable->getUpdated());
    }
}
