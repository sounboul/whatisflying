<?php

declare(strict_types=1);

namespace App\Service\UserManager;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

final class UserManager implements UserManagerInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createUser(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function deleteUser(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function enableUser(User $user): void
    {
        $user->setEnabled(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);
    }

    public function getUserByUsername(string $username): ?User
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['username' => $username]);
    }

    public function lockUser(User $user): void
    {
        $user->setLocked(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function unlockUser(User $user): void
    {
        $user->setLocked(false);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
