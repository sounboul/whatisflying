<?php

declare(strict_types=1);

namespace Tests\Unit\Doctrine\ORM;

use App\Doctrine\ORM\EventSubscriber\TimestampableEventSubscriber;
use App\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Doctrine\ORM\EventSubscriber\TimestampableEventSubscriber
 */
final class TimestampableEventSubscriberTest extends TestCase
{
    /**
     * @testdox Method getSubscribedEvents() returns the event list.
     */
    public function testGetSubscriberEvents(): void
    {
        $timestampableEventSubscriber = new TimestampableEventSubscriber();

        self::assertEquals(
            [Events::prePersist, Events::preUpdate],
            $timestampableEventSubscriber->getSubscribedEvents()
        );
    }

    /**
     * @testdox Method prePersist() sets the entity creation date and time.
     */
    public function testPrePersist(): void
    {
        $entity = $this
            ->getMockBuilder(TimestampableTrait::class)
            ->onlyMethods(['setCreated'])
            ->getMockForTrait();

        $entity
            ->expects(self::once())
            ->method('setCreated')
            ->will(self::returnValue($entity));

        $lifecycleEventArgs = $this
            ->getMockBuilder(LifecycleEventArgs::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getObject'])
            ->getMock();

        $lifecycleEventArgs
            ->method('getObject')
            ->will(self::returnValue($entity));

        $timestampableEventSubscriber = new TimestampableEventSubscriber();
        $timestampableEventSubscriber->prePersist($lifecycleEventArgs);
    }

    /**
     * @testdox Method prePersist() returns early when an incompatible entity is provided.
     */
    public function testPrePersistReturnEarly(): void
    {
        $entity = $this
            ->getMockBuilder(\stdClass::class)
            ->getMock();

        $lifecycleEventArgs = $this
            ->getMockBuilder(LifecycleEventArgs::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getObject'])
            ->getMock();

        $lifecycleEventArgs
            ->method('getObject')
            ->will(self::returnValue($entity));

        $timestampableEventSubscriber = new TimestampableEventSubscriber();
        $timestampableEventSubscriber->prePersist($lifecycleEventArgs);

        self::assertEquals(true, true);
    }

    /**
     * @testdox Method preUpdate() sets the entity modification date and time.
     */
    public function testPreUpdate(): void
    {
        $entity = $this
            ->getMockBuilder(TimestampableTrait::class)
            ->onlyMethods(['setUpdated'])
            ->getMockForTrait();

        $entity
            ->expects(self::once())
            ->method('setUpdated')
            ->will(self::returnValue($entity));

        $preUpdateEventArgs = $this
            ->getMockBuilder(PreUpdateEventArgs::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getObject'])
            ->getMock();

        $preUpdateEventArgs
            ->method('getObject')
            ->will(self::returnValue($entity));

        $timestampableEventSubscriber = new TimestampableEventSubscriber();
        $timestampableEventSubscriber->preUpdate($preUpdateEventArgs);
    }

    /**
     * @testdox Method preUpdate() returns early when an incompatible entity is provided.
     */
    public function testPreUpdateReturnEarly(): void
    {
        $entity = $this
            ->getMockBuilder(\stdClass::class)
            ->getMock();

        $preUpdateEventArgs = $this
            ->getMockBuilder(PreUpdateEventArgs::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getObject'])
            ->getMock();

        $preUpdateEventArgs
            ->method('getObject')
            ->will(self::returnValue($entity));

        $timestampableEventSubscriber = new TimestampableEventSubscriber();
        $timestampableEventSubscriber->preUpdate($preUpdateEventArgs);

        self::assertEquals(true, true);
    }
}
