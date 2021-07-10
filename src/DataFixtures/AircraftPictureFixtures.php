<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Aircraft;
use App\Entity\AircraftPicture;
use Composer\Spdx\SpdxLicenses;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\HttpFoundation\File\File;
use Xvladqt\Faker\LoremFlickrProvider;

final class AircraftPictureFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            AircraftFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();
        $factory->addProvider(new LoremFlickrProvider($factory));

        $spdx = new SpdxLicenses();
        $licenses = array_map('strtoupper', array_keys($spdx->getLicenses()));

        $aircrafts = $manager
            ->getRepository(Aircraft::class)
            ->findAll();

        foreach (range(1, 10) as $seed) {
            $factory->seed($seed);

            $aircraftPicture = new AircraftPicture();
            $aircraftPicture
                ->setAircraft($factory->randomElement($aircrafts))
                ->setAuthorName($factory->name())
                ->setAuthorProfile($factory->optional()->url())
                ->setLicense($factory->randomElement($licenses))
                ->setSource($factory->url())
                ->setLocalFile(new File($factory->image(null, 1200, 800, ['plane'])));

            $manager->persist($aircraftPicture);
        }

        $manager->flush();
        $manager->clear();
    }
}
