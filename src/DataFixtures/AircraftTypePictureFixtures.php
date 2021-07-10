<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\AircraftType;
use App\Entity\AircraftTypePicture;
use Composer\Spdx\SpdxLicenses;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\HttpFoundation\File\File;
use Xvladqt\Faker\LoremFlickrProvider;

final class AircraftTypePictureFixtures extends Fixture implements DependentFixtureInterface
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

        $aircraftTypes = $manager
            ->getRepository(AircraftType::class)
            ->findAll();

        foreach (range(1, 10) as $seed) {
            $factory->seed($seed);

            $aircraftTypePicture = new AircraftTypePicture();
            $aircraftTypePicture
                ->setAircraftType($factory->randomElement($aircraftTypes))
                ->setAuthorName($factory->name())
                ->setAuthorProfile($factory->optional()->url())
                ->setLicense($factory->randomElement($licenses))
                ->setSource($factory->url())
                ->setLocalFile(new File($factory->image(null, 1200, 800, ['plane'])));

            $manager->persist($aircraftTypePicture);
        }

        $manager->flush();
        $manager->clear();
    }
}
