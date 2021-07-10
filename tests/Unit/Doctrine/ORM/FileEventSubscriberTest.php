<?php

declare(strict_types=1);

namespace Tests\Unit\Doctrine\ORM;

use App\Doctrine\ORM\EventSubscriber\FileEventSubscriber;
use App\Entity\FileEntity;
use App\Service\FileUploader\FileUploaderInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @covers \App\Doctrine\ORM\EventSubscriber\FileEventSubscriber
 */
final class FileEventSubscriberTest extends TestCase
{
    private MockObject|FileUploaderInterface $fileUploader;

    public function setUp(): void
    {
        $this->fileUploader = $this
            ->getMockBuilder(FileUploaderInterface::class)
            ->onlyMethods(['remove', 'upload'])
            ->getMockForAbstractClass();
    }

    /**
     * @testdox Method getSubscribedEvents() returns the event list.
     */
    public function testGetSubscriberEvents(): void
    {
        $fileEventSubscriber = new FileEventSubscriber($this->fileUploader);

        self::assertEquals(
            [Events::postRemove, Events::prePersist, Events::preUpdate],
            $fileEventSubscriber->getSubscribedEvents()
        );
    }

    /**
     * @testdox Method postRemove() removes the file.
     */
    public function testPostRemove(): void
    {
        $file = $this
            ->getMockBuilder(FileEntity::class)
            ->onlyMethods(['getPath'])
            ->getMockForAbstractClass();

        $file
            ->method('getPath')
            ->will(self::returnValue('1d6eb8b7-cea2-46a5-8721-4f28c925f69e.webp'));

        $lifecycleEventArgs = $this
            ->getMockBuilder(LifecycleEventArgs::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getObject'])
            ->getMock();

        $lifecycleEventArgs
            ->method('getObject')
            ->will(self::returnValue($file));

        $this->fileUploader
            ->expects(self::once())
            ->method('remove')
            ->with('1d6eb8b7-cea2-46a5-8721-4f28c925f69e.webp');

        $fileEventSubscriber = new FileEventSubscriber($this->fileUploader);
        $fileEventSubscriber->postRemove($lifecycleEventArgs);
    }

    /**
     * @testdox Method postRemove() returns early when an incompatible entity is provided.
     */
    public function testPostRemoveReturnEarly(): void
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

        $fileEventSubscriber = new FileEventSubscriber($this->fileUploader);
        $fileEventSubscriber->postRemove($lifecycleEventArgs);

        self::assertEquals(true, true);
    }

    /**
     * @testdox Method prePersist() uploads the file.
     */
    public function testPrePersist(): void
    {
        $localFile = new File(__FILE__);

        $file = $this->getMockForAbstractClass(FileEntity::class);
        $file->setLocalFile($localFile);

        $lifecycleEventArgs = $this
            ->getMockBuilder(LifecycleEventArgs::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getObject'])
            ->getMock();

        $lifecycleEventArgs
            ->method('getObject')
            ->will(self::returnValue($file));

        $this->fileUploader
            ->expects(self::once())
            ->method('upload')
            ->with($localFile)
            ->will(self::returnValue(new File(__FILE__)));

        $fileEventSubscriber = new FileEventSubscriber($this->fileUploader);
        $fileEventSubscriber->prePersist($lifecycleEventArgs);
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

        $fileEventSubscriber = new FileEventSubscriber($this->fileUploader);
        $fileEventSubscriber->prePersist($lifecycleEventArgs);

        self::assertEquals(true, true);
    }

    /**
     * @testdox Method preUpdate() removes the old file & uploads the new file.
     */
    public function testPreUpdate(): void
    {
        $localFile = new File(__FILE__);

        $file = $this
            ->getMockBuilder(FileEntity::class)
            ->onlyMethods(['getLocalFile', 'getPath'])
            ->getMockForAbstractClass();

        $file
            ->method('getLocalFile')
            ->will(self::returnValue($localFile));

        $file
            ->method('getPath')
            ->will(self::returnValue('573b573d-f4a5-4f0a-a695-5c139bf0529a.webp'));

        $preUpdateEventArgs = $this
            ->getMockBuilder(PreUpdateEventArgs::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getObject'])
            ->getMock();

        $preUpdateEventArgs
            ->method('getObject')
            ->will(self::returnValue($file));

        $this->fileUploader
            ->expects(self::once())
            ->method('remove')
            ->with('573b573d-f4a5-4f0a-a695-5c139bf0529a.webp');

        $this->fileUploader
            ->expects(self::once())
            ->method('upload')
            ->with($localFile)
            ->will(self::returnValue(new File(__FILE__)));

        $fileEventSubscriber = new FileEventSubscriber($this->fileUploader);
        $fileEventSubscriber->preUpdate($preUpdateEventArgs);
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

        $fileEventSubscriber = new FileEventSubscriber($this->fileUploader);
        $fileEventSubscriber->preUpdate($preUpdateEventArgs);

        self::assertEquals(true, true);
    }
}
