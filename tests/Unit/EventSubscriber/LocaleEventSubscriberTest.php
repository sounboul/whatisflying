<?php

declare(strict_types=1);

namespace Tests\Unit\EventSubscriber;

use App\EventSubscriber\LocaleEventSubscriber;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @covers \App\EventSubscriber\LocaleEventSubscriber
 */
final class LocaleEventSubscriberTest extends TestCase
{
    /**
     * @testdox Method getSubscribedEvents() returns the event list.
     */
    public function testGetSubscribedEvents(): void
    {
        self::assertEquals(
            [KernelEvents::REQUEST => ['onKernelRequest', 20]],
            LocaleEventSubscriber::getSubscribedEvents()
        );
    }

    /**
     * @testdox Method onKernelRequest() sets the request locale.
     */
    public function testOnKernelRequest(): void
    {
        $request = $this
            ->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['setLocale'])
            ->getMock();

        $request->headers = $this
            ->getMockBuilder(HeaderBag::class)
            ->getMock();

        $request->headers
            ->method('has')
            ->with('Accept-Language')
            ->will(self::returnValue(true));

        $request->headers
            ->method('get')
            ->with('Accept-Language')
            ->will(self::returnValue('fr'));

        $request
            ->expects(self::once())
            ->method('setLocale')
            ->with('fr');

        $event = $this
            ->getMockBuilder(RequestEvent::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event
            ->method('getRequest')
            ->will(self::returnValue($request));

        $eventSubscriber = new LocaleEventSubscriber();
        $eventSubscriber->onKernelRequest($event);
    }
}
