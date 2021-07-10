<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Aircraft;
use App\Entity\AircraftType;
use App\Entity\Airline;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class AircraftFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            AircraftTypeFixtures::class,
            AirlineFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();

        $airlines = $manager
            ->getRepository(Airline::class)
            ->findAll();

        $aircraftTypes = $manager
            ->getRepository(AircraftType::class)
            ->findAll();

        foreach (range(1, 1000) as $seed) {
            $factory->seed($seed);
            $description = $factory->regexify('[AGHLT][1234568][EJPT]');

            $aircraft = new Aircraft();
            $aircraft
                ->setAircraftFamily(substr($description, 0, 1))
                ->setAircraftType($factory->optional()->randomElement($aircraftTypes))
                ->setDescription($description)
                ->setEngineCount((int)substr($description, 1, 1))
                ->setEngineType(substr($description, 2, 1))
                ->setIcao24bitAddress($factory->unique()->regexify('[a-f0-9]{6}'))
                ->setManufacturer($factory->company())
                ->setManufactured($factory->optional()->dateTime())
                ->setModel($factory->regexify('[A-Z]?[0-9]{2,3}'))
                ->setOperator($factory->optional()->randomElement($airlines))
                ->setRegistered($factory->optional()->dateTime())
                ->setRegisteredUntil($factory->optional()->dateTime())
                ->setRegistration($factory->regexify('[A-Z]\-[A-Z]{4}'))
                ->setRegistrationCountry($factory->optional()->countryCode())
                ->setSerialNumber($factory->regexify('[0-9]{1,10}'));

            $manager->persist($aircraft);
        }

        $manager->flush();
        $manager->clear();
    }
}
