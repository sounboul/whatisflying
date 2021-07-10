<?php

declare(strict_types=1);

namespace App\Doctrine\ORM\EventSubscriber;

use App\Util\DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

final class TimestampableEventSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!method_exists($entity, 'setCreated')) {
            return;
        }

        $entity->setCreated(DateTime::getCurrentUtc());
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!method_exists($entity, 'setUpdated')) {
            return;
        }

        $entity->setUpdated(DateTime::getCurrentUtc());
    }
}
