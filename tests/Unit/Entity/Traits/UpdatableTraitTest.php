<?php

declare(strict_types=1);

namespace Tests\Unit\Entity\Traits;

use App\Entity\Attributes\Updatable;
use App\Entity\Traits\UpdatableTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Traits\UpdatableTrait
 */
final class UpdatableTraitTest extends TestCase
{
    /**
     * @testdox Method update() updates the updatable properties of the entity.
     */
    public function testUpdate(): void
    {
        $source = new class {
            use UpdatableTrait;

            #[Updatable]
            public mixed $updatableProperty;
            public mixed $nonUpdatableProperty;
        };

        $source->updatableProperty = 'new_value';
        $source->nonUpdatableProperty = 'new_value';

        $target = clone $source;
        $target->updatableProperty = 'old_value';
        $target->nonUpdatableProperty = 'old_value';

        $target->update($source);

        self::assertEquals('new_value', $target->updatableProperty);
        self::assertEquals('old_value', $target->nonUpdatableProperty);
    }

    /**
     * @testdox Method update() throws when an instance of a different class is provided.
     */
    public function testUpdateThrowOnDifferentClassInstance(): void
    {
        $target = $this
            ->getMockBuilder(UpdatableTrait::class)
            ->getMockForTrait();

        $source = $this
            ->getMockBuilder(\stdClass::class)
            ->getMock();

        self::expectException(\LogicException::class);

        $target->update($source);
    }
}
