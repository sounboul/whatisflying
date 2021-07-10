<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Airport;
use App\Entity\Fir;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class AirportFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            FirFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();

        $firs = $manager->getRepository(Fir::class)
                        ->findAll();

        foreach (range(1, 100) as $seed) {
            $factory->seed($seed);

            $airport = new Airport();
            $airport
                ->setActive($factory->boolean())
                ->setContinent($factory->randomElement(['AF', 'AN', 'AS', 'EU', 'NA', 'OC', 'SA']))
                ->setCountry($factory->countryCode())
                ->setFir($factory->randomElement($firs))
                ->setElevation($factory->optional()->numberBetween(-1000, 1000))
                ->setIataCode($factory->optional()->passthrough($factory->unique()->regexify('[A-Z]{3}')))
                ->setIcaoCode($factory->unique()->regexify('[A-Z]{4}'))
                ->setInternational($factory->boolean())
                ->setLatitude($factory->latitude())
                ->setLongitude($factory->longitude())
                ->setName($factory->city())
                ->setType($factory->randomElement(['small', 'medium', 'large']));

            $manager->persist($airport);
        }

        $manager->flush();
        $manager->clear();
    }
}
