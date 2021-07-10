<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Service\SitemapGenerator\SitemapGeneratorInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class SitemapEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private SitemapGeneratorInterface $sitemapGenerator)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SitemapPopulateEvent::ON_SITEMAP_POPULATE => 'onSitemapPopulate',
        ];
    }

    public function onSitemapPopulate(SitemapPopulateEvent $event): void
    {
        if (in_array($event->getSection(), [null, 'aircraft'], true)) {
            $this->sitemapGenerator->generateAircraftSitemap($event->getUrlContainer());
        }

        if (in_array($event->getSection(), [null, 'aircraft_types'], true)) {
            $this->sitemapGenerator->generateAircraftTypesSitemap($event->getUrlContainer());
        }

        if (in_array($event->getSection(), [null, 'airlines'], true)) {
            $this->sitemapGenerator->generateAirlinesSitemap($event->getUrlContainer());
        }

        if (in_array($event->getSection(), [null, 'airports'], true)) {
            $this->sitemapGenerator->generateAirportsSitemap($event->getUrlContainer());
        }

        if (in_array($event->getSection(), [null, 'flights'], true)) {
            $this->sitemapGenerator->generateFlightsSitemap($event->getUrlContainer());
        }

        if (in_array($event->getSection(), [null, 'navaids'], true)) {
            $this->sitemapGenerator->generateNavaidsSitemap($event->getUrlContainer());
        }
    }
}
