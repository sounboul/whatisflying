<?php

declare(strict_types=1);

namespace App\Service\SitemapGenerator;

use Presta\SitemapBundle\Service\UrlContainerInterface;

interface SitemapGeneratorInterface
{
    /**
     * Generates the sitemap entries for the aircraft.
     *
     * @param UrlContainerInterface $urlContainer The URL container to which the URLs will be added.
     */
    public function generateAircraftSitemap(UrlContainerInterface $urlContainer): void;

    /**
     * Generates the sitemap entries for the aircraft types.
     * 
     * @param UrlContainerInterface $urlContainer The URL container to which the URLs will be added.
     */
    public function generateAircraftTypesSitemap(UrlContainerInterface $urlContainer): void;

    /**
     * Generates the sitemap entries from the airlines.
     * 
     * @param UrlContainerInterface $urlContainer The URL container to which the URLs will be added.
     */
    public function generateAirlinesSitemap(UrlContainerInterface $urlContainer): void;

    /**
     * Generates the sitemap entries for the airports.
     * 
     * @param UrlContainerInterface $urlContainer The URL container to which the URLs will be added.
     */
    public function generateAirportsSitemap(UrlContainerInterface $urlContainer): void;

    /**
     * Generates the sitemap entries for the flights.
     * 
     * @param UrlContainerInterface $urlContainer The URL container to which the URLs will be added.
     */
    public function generateFlightsSitemap(UrlContainerInterface $urlContainer): void;

    /**
     * Generates the sitemap entries for the navaids.
     * 
     * @param UrlContainerInterface $urlContainer The URL container to which the URLs will be added.
     */
    public function generateNavaidsSitemap(UrlContainerInterface $urlContainer): void;
}
