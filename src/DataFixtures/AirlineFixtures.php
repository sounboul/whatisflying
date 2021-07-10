<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Airline;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class AirlineFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();

        foreach (range(1, 100) as $seed) {
            $factory->seed($seed);

            $airline = new Airline();
            $airline
                ->setAccidentsLast5Years($factory->optional()->numberBetween(0, 10))
                ->setActive($factory->boolean())
                ->setAircraftOver25Years($factory->optional()->numberBetween(0, 10))
                ->setAnnualDomesticFlights($factory->optional()->numberBetween(0, 10000))
                ->setAnnualInternationalFlights($factory->optional()->numberBetween(0, 10000))
                ->setAverageFleetAge($factory->optional()->randomFloat(2, 0, 50))
                ->setCallsign($factory->optional()->passthrough(strtoupper($factory->words(2, true))))
                ->setCountry($factory->countryCode())
                ->setDestinations($factory->optional()->numberBetween(1, 100))
                ->setFatalAccidentsLast5Years($factory->optional()->numberBetween(0, 10))
                ->setIataCode($factory->optional()->passthrough($factory->unique()->regexify('[A-Z0-9]{2}\*?')))
                ->setIataMember($factory->boolean())
                ->setIcaoCode($factory->unique()->regexify('[A-Z]{3}'))
                ->setInternational($factory->boolean())
                ->setIosaCertified($factory->boolean())
                ->setName($factory->company());

            $manager->persist($airline);
        }

        $manager->flush();
        $manager->clear();
    }
}
