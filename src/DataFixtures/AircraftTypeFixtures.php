<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\AircraftType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class AircraftTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();

        foreach (range(1, 100) as $seed) {
            $factory->seed($seed);
            $description = $factory->regexify('[AGHLT][1234568][EJPT]');

            $aircraftType = new AircraftType();
            $aircraftType
                ->setAbsoluteCeiling($factory->optional()->numberBetween(10000, 100000))
                ->setAircraftFamily($factory->optional()->passthrough(substr($description, 0, 1)))
                ->setApproachSpeed($factory->optional()->numberBetween(100, 1000))
                ->setAuw($factory->optional()->numberBetween(100, 100000))
                ->setClimbRate($factory->optional()->numberBetween(100, 1000))
                ->setCruiseSpeed($factory->optional()->numberBetween(100, 1000))
                ->setDescription($factory->optional()->passthrough($description))
                ->setEngineCount($factory->optional()->passthrough((int)substr($description, 1, 1)))
                ->setEngineType($factory->optional()->passthrough(substr($description, 2, 1)))
                ->setFerryRange($factory->optional()->numberBetween(1000, 10000))
                ->setFuelCapacity($factory->optional()->numberBetween(10000, 100000))
                ->setFuselageHeight($factory->optional()->numberBetween(10, 100))
                ->setFuselageWidth($factory->optional()->numberBetween(10, 100))
                ->setHeight($factory->optional()->numberBetween(10, 100))
                ->setIataCode($factory->optional()->passthrough($factory->unique()->regexify('[A-Z0-9]{3}')))
                ->setIcaoCode($factory->unique()->regexify('[A-Z0-9]{2,4}'))
                ->setLength($factory->optional()->numberBetween(10, 100))
                ->setMainRotorArea($factory->optional()->numberBetween(10, 100))
                ->setMainRotorDiameter($factory->optional()->numberBetween(10, 100))
                ->setManufacturer($factory->company())
                ->setMaximumSpeed($factory->optional()->numberBetween(100, 1000))
                ->setMlw($factory->optional()->numberBetween(10000, 100000))
                ->setMrw($factory->optional()->numberBetween(10000, 100000))
                ->setMtow($factory->optional()->numberBetween(10000, 100000))
                ->setMzfw($factory->optional()->numberBetween(10000, 100000))
                ->setName($factory->regexify('[A-Z]?[0-9]{2,3}'))
                ->setNeverExceedSpeed($factory->optional()->numberBetween(100, 1000))
                ->setOew($factory->optional()->numberBetween(10000, 100000))
                ->setOperatingRange($factory->optional()->numberBetween(1000, 10000))
                ->setServiceCeiling($factory->optional()->numberBetween(10000, 100000))
                ->setTypeCertificate($factory->optional()->url())
                ->setWingArea($factory->optional()->numberBetween(10, 100))
                ->setWingspan($factory->optional()->numberBetween(10, 100))
                ->setWtc($factory->optional()->regexify('[HLM]'));

            $manager->persist($aircraftType);
        }

        $manager->flush();
        $manager->clear();
    }
}
