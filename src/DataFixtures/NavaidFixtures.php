<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Airport;
use App\Entity\Navaid;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class NavaidFixtures extends Fixture implements DependentFixtureInterface
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

            $navaid = new Navaid();
            $navaid
                ->setAirport($factory->optional()->randomElement($airports))
                ->setAirportRunway($factory->optional()->regexify('([0-2][0-9]|3[0-6])[CLR]?'))
                ->setCountry($factory->countryCode())
                ->setDmeBias($factory->optional()->randomFloat(2, 0, 5))
                ->setDmeChannel($factory->optional()->regexify('[XY][0-9]{3}'))
                ->setDmeRXFrequency($factory->optional()->numberBetween(1e6, 1.5e6))
                ->setDmeTXFrequency($factory->optional()->numberBetween(1e6, 1.5e6))
                ->setElevation($factory->optional()->numberBetween(-1000, 1000))
                ->setFrequency($factory->numberBetween(1000000, 150000))
                ->setGlideSlopeAngle($factory->optional()->randomFloat(2, 2.5, 3.5))
                ->setIdentifier($factory->regexify('[A-Z]{1,4}'))
                ->setLatitude($factory->latitude())
                ->setLocalizerHeading($factory->optional()->randomFloat(3, 0, 360))
                ->setLongitude($factory->longitude())
                ->setName($factory->city())
                ->setReceptionRange($factory->numberBetween(15, 150))
                ->setRegion($factory->regexify('[A-Z0-9]{2}'))
                ->setSlug($factory->unique()->slug(5, true))
                ->setType(
                    $factory->randomElement(
                        [
                            'DME',
                            'DME-ILS',
                            'DME-NDB',
                            'GS',
                            'IGS',
                            'ILS-I',
                            'ILS-II',
                            'ILS-III',
                            'IM',
                            'LDA',
                            'LOC',
                            'MM',
                            'NDB',
                            'OM',
                            'SDF',
                            'TACAN',
                            'VOR',
                            'VOR-DME',
                            'VORTAC',
                        ]
                    )
                )
                ->setUsage($factory->randomElement(['ENROUTE', 'TERMINAL']))
                ->setVorSlavedVariation($factory->optional()->randomFloat(3, -15, 15));

            $manager->persist($navaid);
        }

        $manager->flush();
        $manager->clear();
    }
}
