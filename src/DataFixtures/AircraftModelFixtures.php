<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class AircraftModelFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            AircraftTypeFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();

        $aircraftTypes = $manager
            ->getRepository(AircraftType::class)
            ->findAll();

        foreach (range(1, 100) as $seed) {
            $factory->seed($seed);

            $aircraftModel = new AircraftModel();
            $aircraftModel
                ->setAircraftType($factory->randomElement($aircraftTypes))
                ->setCertified($factory->dateTime())
                ->setEngineManufacturer($factory->company())
                ->setEngineModel($factory->regexify('[A-Z]{2}-[A-Z0-9]{4,6}'))
                ->setName($factory->regexify('[A-Z]?[0-9]{2,3}'));

            $manager->persist($aircraftModel);
        }

        $manager->flush();
        $manager->clear();
    }
}
