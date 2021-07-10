<?php

declare(strict_types=1);

namespace App\Service\SitemapGenerator;

use App\Entity\Aircraft;
use App\Entity\AircraftType;
use App\Entity\Airline;
use App\Entity\Airport;
use App\Entity\Flight;
use App\Entity\Navaid;
use App\Repository\AircraftRepository;
use App\Repository\AircraftTypeRepository;
use App\Repository\AirlineRepository;
use App\Repository\AirportRepository;
use App\Repository\FlightRepository;
use App\Repository\NavaidRepository;
use Doctrine\ORM\EntityManagerInterface;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class SitemapGenerator implements SitemapGeneratorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function generateAircraftSitemap(UrlContainerInterface $urlContainer): void
    {
        /** @var AircraftRepository $repository */
        $repository = $this->entityManager->getRepository(Aircraft::class);
        $aircrafts = $repository->findAllIcao24bitAddress();

        foreach ($aircrafts as $aircraft) {
            $url = $this->urlGenerator->generate(
                'database_aircraft',
                ['icao24bitAddress' => $aircraft->getIcao24bitAddress()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $urlContainer->addUrl(new UrlConcrete($url), 'aircraft');
        }
    }

    public function generateAircraftTypesSitemap(UrlContainerInterface $urlContainer): void
    {
        /** @var AircraftTypeRepository $repository */
        $repository = $this->entityManager->getRepository(AircraftType::class);
        $aircraftTypes = $repository->findAllIcaoCode();

        foreach ($aircraftTypes as $aircraftType) {
            $url = $this->urlGenerator->generate(
                'database_aircraft_type',
                ['icaoCode' => $aircraftType->getIcaoCode()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $urlContainer->addUrl(new UrlConcrete($url), 'aircraft_types');
        }
    }

    public function generateAirlinesSitemap(UrlContainerInterface $urlContainer): void
    {
        /** @var AirlineRepository $repository */
        $repository = $this->entityManager->getRepository(Airline::class);
        $airlines = $repository->findAllIcaoCode();

        foreach ($airlines as $airline) {
            $url = $this->urlGenerator->generate(
                'database_airline',
                ['icaoCode' => $airline->getIcaoCode()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $urlContainer->addUrl(new UrlConcrete($url), 'airlines');
        }
    }

    public function generateAirportsSitemap(UrlContainerInterface $urlContainer): void
    {
        /** @var AirportRepository $repository */
        $repository = $this->entityManager->getRepository(Airport::class);
        $airports = $repository->findAllIcaoCode();

        foreach ($airports as $airport) {
            $url = $this->urlGenerator->generate(
                'database_airport',
                ['icaoCode' => $airport->getIcaoCode()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $urlContainer->addUrl(new UrlConcrete($url), 'airports');
        }
    }

    public function generateFlightsSitemap(UrlContainerInterface $urlContainer): void
    {
        /** @var FlightRepository $repository */
        $repository = $this->entityManager->getRepository(Flight::class);
        $flights = $repository->findAllFlightNumber();

        foreach ($flights as $flight) {
            $url = $this->urlGenerator->generate(
                'database_flight',
                ['flightNumber' => $flight->getFlightNumber()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $urlContainer->addUrl(new UrlConcrete($url), 'flights');
        }
    }

    public function generateNavaidsSitemap(UrlContainerInterface $urlContainer): void
    {
        /** @var NavaidRepository $repository */
        $repository = $this->entityManager->getRepository(Navaid::class);
        $navaids = $repository->findAllSlug();

        foreach ($navaids as $navaid) {
            $url = $this->urlGenerator->generate(
                'database_navaid',
                ['slug' => $navaid->getSlug()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $urlContainer->addUrl(new UrlConcrete($url), 'navaids');
        }
    }
}
