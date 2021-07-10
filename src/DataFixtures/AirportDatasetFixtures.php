<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Airport;
use App\Entity\AirportDataset;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class AirportDatasetFixtures extends Fixture implements DependentFixtureInterface
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

            $airportDataset = new AirportDataset();
            $airportDataset
                ->setAirport($factory->randomElement($airports))
                ->setDomesticDepartures($factory->numberBetween(0, 100000))
                ->setDomesticDestinations($factory->numberBetween(0, 100))
                ->setInternationalDepartures($factory->numberBetween(0, 100000))
                ->setInternationalDestinations($factory->numberBetween(0, 100))
                ->setYear((int)$factory->year());

            $manager->persist($airportDataset);
        }

        $manager->flush();
        $manager->clear();
    }
}
