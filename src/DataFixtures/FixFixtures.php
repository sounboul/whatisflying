<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Airport;
use App\Entity\Fix;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class FixFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();
        $airports = $manager
            ->getRepository(Airport::class)
            ->findAll();

        foreach (range(1, 1000) as $seed) {
            $factory->seed($seed);

            $fix = new Fix();
            $fix
                ->setAirport($factory->optional()->randomElement($airports))
                ->setIdentifier($factory->regexify('[A-Z0-9]{1,5}'))
                ->setLatitude($factory->latitude())
                ->setLongitude($factory->longitude())
                ->setRegion($factory->regexify('[A-Z0-9]{2}'))
                ->setSlug($factory->unique()->slug(5, true))
                ->setUsage($factory->randomElement(['ENROUTE', 'TERMINAL']));

            $manager->persist($fix);
        }

        $manager->flush();
        $manager->clear();
    }
}
