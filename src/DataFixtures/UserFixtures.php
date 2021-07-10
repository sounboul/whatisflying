<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setEmail('admin@whatisflying.com')
            ->setEnabled(true)
            ->setLocale('EN')
            ->setPlainPassword('whatisflying')
            ->addRole('ROLE_ADMIN')
            ->setUsername('admin');

        $manager->persist($user);
        $manager->flush();

        $factory = Factory::create();

        foreach (range(1, 100) as $seed) {
            $factory->seed($seed);

            $user = new User();
            $user
                ->setEmail($factory->unique()->email())
                ->setEnabled($factory->boolean(90))
                ->setLocale($factory->randomElement(['EN', 'FR']))
                ->setUsername($factory->unique()->userName())
                ->setPlainPassword($factory->password());

            $manager->persist($user);
        }

        $manager->flush();
        $manager->clear();
    }
}
