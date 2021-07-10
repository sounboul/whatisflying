<?php

declare(strict_types=1);

namespace Tests\Unit\Doctrine\ORM;

use App\Doctrine\ORM\EventSubscriber\UserEventSubscriber;
use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @covers \App\Doctrine\ORM\EventSubscriber\UserEventSubscriberTest
 */
final class UserEventSubscriberTest extends TestCase
{
    private MockObject|UserPasswordHasherInterface $userPasswordHasher;

    public function setUp(): void
    {
        $this->userPasswordHasher = $this
            ->getMockBuilder(UserPasswordHasherInterface::class)
            ->addMethods(['hashPassword'])
            ->getMockForAbstractClass();
    }

    /**
     * @testdox Method getSubscribedEvents() returns the event list.
     */
    public function testGetSubscriberEvents(): void
    {
        $userEventSubscriber = new UserEventSubscriber($this->userPasswordHasher);

        self::assertEquals(
            [Events::prePersist, Events::preUpdate],
            $userEventSubscriber->getSubscribedEvents()
        );
    }

    /**
     * @testdox Method prePersist() hashes & sets the user password.
     */
    public function testPrePersist(): void
    {
        $entity = $this
            ->getMockBuilder(User::class)
            ->onlyMethods(['getPlainPassword', 'setPassword'])
            ->getMock();

        $entity
            ->method('getPlainPassword')
            ->will(self::returnValue('XksexwT9'));

        $entity
            ->expects(self::once())
            ->method('setPassword');

        $lifecycleEventArgs = $this
            ->getMockBuilder(LifecycleEventArgs::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getObject'])
            ->getMock();

        $lifecycleEventArgs
            ->method('getObject')
            ->will(self::returnValue($entity));

        $this->userPasswordHasher
            ->expects(self::once())
            ->method('hashPassword')
            ->with($entity, 'XksexwT9')
            ->will(self::returnValue('$2y$10$a7aNda0XzLSEPxwonSs1BO.TtjOPVkUEBPGZxHF05X4F45HOMYyLW'));

        $userEventSubscriber = new UserEventSubscriber($this->userPasswordHasher);
        $userEventSubscriber->prePersist($lifecycleEventArgs);
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

        $userEventSubscriber = new UserEventSubscriber($this->userPasswordHasher);
        $userEventSubscriber->prePersist($lifecycleEventArgs);

        self::assertEquals(true, true);
    }

    /**
     * @testdox Method preUpdate() hashes & sets the user password.
     */
    public function testPreUpdate(): void
    {
        $entity = $this
            ->getMockBuilder(User::class)
            ->onlyMethods(['getPlainPassword', 'setPassword'])
            ->getMock();

        $entity
            ->method('getPlainPassword')
            ->will(self::returnValue('Z7$h4eLoKs'));

        $entity
            ->expects(self::once())
            ->method('setPassword');

        $preUpdateEventArgs = $this
            ->getMockBuilder(PreUpdateEventArgs::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getObject'])
            ->getMock();

        $preUpdateEventArgs
            ->method('getObject')
            ->will(self::returnValue($entity));

        $this->userPasswordHasher
            ->expects(self::once())
            ->method('hashPassword')
            ->with($entity, 'Z7$h4eLoKs')
            ->will(self::returnValue('$2y$10$CqugXuxT4sZNMmiCSWU7B.IeSJIxRbieOXgRX2Eni5cPjBALIjS9S'));

        $userEventSubscriber = new UserEventSubscriber($this->userPasswordHasher);
        $userEventSubscriber->preUpdate($preUpdateEventArgs);
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

        $userEventSubscriber = new UserEventSubscriber($this->userPasswordHasher);
        $userEventSubscriber->preUpdate($preUpdateEventArgs);

        self::assertEquals(true, true);
    }
}
