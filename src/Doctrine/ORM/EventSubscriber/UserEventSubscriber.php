<?php

declare(strict_types=1);

namespace App\Doctrine\ORM\EventSubscriber;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserEventSubscriber implements EventSubscriber
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $user = $args->getObject();

        if (!$user instanceof User) {
            return;
        }

        $this->encodeUserPassword($user);
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $user = $args->getObject();

        if (!$user instanceof User) {
            return;
        }

        if (!is_null($user->getPlainPassword())) {
            $this->encodeUserPassword($user);
        }
    }

    private function encodeUserPassword(User $user): void
    {
        $password = $this->userPasswordHasher->hashPassword($user, $user->getPlainPassword());
        $user
            ->setPassword($password)
            ->eraseCredentials();
    }
}
