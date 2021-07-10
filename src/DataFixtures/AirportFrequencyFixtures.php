<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Airport;
use App\Entity\AirportFrequency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class AirportFrequencyFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            AirportFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();

        $airports = $manager->getRepository(Airport::class)
                            ->findAll();

        foreach (range(1, 1000) as $seed) {
            $factory->seed($seed);

            $airportFrequency = new AirportFrequency();
            $airportFrequency
                ->setAirport($factory->randomElement($airports))
                ->setDescription(strtoupper($factory->words(3, true)))
                ->setFrequency($factory->numberBetween(100000, 150000))
                ->setType($factory->regexify('[A-Z]{4}'));

            $manager->persist($airportFrequency);
        }

        $manager->flush();
        $manager->clear();
    }
}
