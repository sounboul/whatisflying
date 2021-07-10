<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Fir;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class FirFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();

        foreach (range(1, 100) as $seed) {
            $factory->seed($seed);

            $fir = new Fir();
            $fir
                ->setIcaoCode($factory->unique()->regexify('[A-Z]{4}'))
                ->setName(strtoupper($factory->city()));

            $manager->persist($fir);
        }

        $manager->flush();
        $manager->clear();
    }
}
