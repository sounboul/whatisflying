<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Airline;
use App\Entity\Airport;
use App\Entity\Flight;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class FlightFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            AirlineFixtures::class,
            AirportFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();

        $airlines = $manager
            ->getRepository(Airline::class)
            ->findAll();

        $airports = $manager
            ->getRepository(Airport::class)
            ->findAll();

        foreach (range(1, 1000) as $seed) {
            $factory->seed($seed);

            $flight = new Flight();
            $flight
                ->setAirline($factory->randomElement($airlines))
                ->setArrivalAirport($factory->randomElement($airports))
                ->setDepartureAirport($factory->randomElement($airports))
                ->setFlightNumber($factory->regexify('[A-Z]{3}[0-9]{1,4}[A-Z]?'))
                ->setLayoverAirports(
                    new ArrayCollection($factory->optional(0.1, [])->randomElements($airports, 2, false))
                );

            $manager->persist($flight);
        }

        $manager->flush();
        $manager->clear();
    }
}
