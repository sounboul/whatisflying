<?php

declare(strict_types=1);

namespace Tests\Unit\Doctrine\ORM;

use App\Doctrine\ORM\EventSubscriber\PictureEventSubscriber;
use App\Entity\Picture;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @covers \App\Doctrine\ORM\EventSubscriber\PictureEventSubscriber
 */
final class PictureEventSubscriberTest extends TestCase
{
    private ?string $file = null;

    public function setUp(): void
    {
        $factory = Factory::create();
        $this->file = $factory->image(sys_get_temp_dir(), 1920, 1080);
    }

    /**
     * @testdox Method getSubscribedEvents() returns the event list.
     */
    public function testGetSubscriberEvents(): void
    {
        $pictureEventSubscriber = new PictureEventSubscriber();

        self::assertEquals(
            [Events::prePersist, Events::preUpdate],
            $pictureEventSubscriber->getSubscribedEvents()
        );
    }

    /**
     * @testdox Method prePersist() sets the picture size.
     */
    public function testPrePersist(): void
    {
        $entity = $this
            ->getMockBuilder(Picture::class)
            ->onlyMethods(['setHeight', 'getLocalFile', 'setWidth'])
            ->getMockForAbstractClass();

        $entity
            ->method('getLocalFile')
            ->will(self::returnValue(new File($this->file)));

        $entity
            ->expects(self::once())
            ->method('setHeight')
            ->will(self::returnValue($entity));

        $entity
            ->expects(self::once())
            ->method('setWidth')
            ->will(self::returnValue($entity));

        $lifecycleEventArgs = $this
            ->getMockBuilder(LifecycleEventArgs::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getObject'])
            ->getMock();

        $lifecycleEventArgs
            ->expects(self::once())
            ->method('getObject')
            ->will(self::returnValue($entity));

        $pictureEventSubscriber = new PictureEventSubscriber();
        $pictureEventSubscriber->prePersist($lifecycleEventArgs);
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

        $pictureEventSubscriber = new PictureEventSubscriber();
        $pictureEventSubscriber->prePersist($lifecycleEventArgs);

        self::assertEquals(true, true);
    }

    /**
     * @testdox Method preUpdate() updates the picture size.
     */
    public function testPreUpdate(): void
    {
        $entity = $this
            ->getMockBuilder(Picture::class)
            ->onlyMethods(['getLocalFile', 'setHeight', 'setWidth'])
            ->getMockForAbstractClass();

        $entity
            ->method('getLocalFile')
            ->will(self::returnValue(new File($this->file)));

        $entity
            ->expects(self::once())
            ->method('setHeight')
            ->will(self::returnValue($entity));

        $entity
            ->expects(self::once())
            ->method('setWidth')
            ->will(self::returnValue($entity));

        $preUpdateEventArgs = $this
            ->getMockBuilder(PreUpdateEventArgs::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getObject'])
            ->getMock();

        $preUpdateEventArgs
            ->expects(self::once())
            ->method('getObject')
            ->will(self::returnValue($entity));

        $pictureEventSubscriber = new PictureEventSubscriber();
        $pictureEventSubscriber->preUpdate($preUpdateEventArgs);
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

        $pictureEventSubscriber = new PictureEventSubscriber();
        $pictureEventSubscriber->preUpdate($preUpdateEventArgs);

        self::assertEquals(true, true);
    }

    public function tearDown(): void
    {
        if (!is_null($this->file)) {
            unlink($this->file);
        }
    }
}
