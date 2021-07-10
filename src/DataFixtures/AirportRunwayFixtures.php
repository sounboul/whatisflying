<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Airport;
use App\Entity\AirportRunway;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class AirportRunwayFixtures extends Fixture implements DependentFixtureInterface
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

        $airports = $manager
            ->getRepository(Airport::class)
            ->findAll();

        foreach (range(1, 1000) as $seed) {
            $factory->seed($seed);

            $airportRunway = new AirportRunway();
            $airportRunway
                ->setActive($factory->boolean())
                ->setAirport($factory->randomElement($airports))
                ->setHEDisplacedThreshold($factory->optional()->numberBetween(0, 500))
                ->setHEElevation($factory->optional()->numberBetween(-1000, 1000))
                ->setHEHeading($factory->optional()->randomFloat(1, 0, 360))
                ->setHELatitude($factory->latitude())
                ->setHELongitude($factory->longitude())
                ->setHEName($factory->regexify('([0-2][0-9]|3[0-6])[CLR]?'))
                ->setLength($factory->numberBetween(1000, 5000))
                ->setLighted($factory->boolean())
                ->setLEDisplacedThreshold($factory->optional()->numberBetween(0, 500))
                ->setLEElevation($factory->optional()->numberBetween(-1000, 1000))
                ->setLEHeading($factory->optional()->randomFloat(1, 0, 360))
                ->setLELatitude($factory->latitude())
                ->setLELongitude($factory->longitude())
                ->setLEName($factory->regexify('([0-2][0-9]|3[0-6])[CLR]?'))
                ->setSurface(
                    $factory->optional()->randomElement(
                        [
                            'ASP',
                            'BIT',
                            'BRI',
                            'CLA',
                            'COM',
                            'CON',
                            'COP',
                            'COR',
                            'GRE',
                            'GRS',
                            'GVL',
                            'ICE',
                            'LAT',
                            'MAC',
                            'PEM',
                            'PER',
                            'PSP',
                            'SAN',
                            'SMT',
                            'SNO',
                        ]
                    )
                )
                ->setWidth($factory->numberBetween(100, 500));

            $manager->persist($airportRunway);
        }

        $manager->flush();
        $manager->clear();
    }
}
