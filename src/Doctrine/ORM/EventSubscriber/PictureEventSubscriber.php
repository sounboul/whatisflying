<?php

declare(strict_types=1);

namespace App\Doctrine\ORM\EventSubscriber;

use App\Entity\Picture;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

final class PictureEventSubscriber implements EventSubscriber
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
        $picture = $args->getObject();

        if (!$picture instanceof Picture) {
            return;
        }

        if (!is_null($picture->getLocalFile())) {
            $this->setPictureSize($picture);
        }
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $picture = $args->getObject();

        if (!$picture instanceof Picture) {
            return;
        }

        if (!is_null($picture->getLocalFile())) {
            $this->setPictureSize($picture);
        }
    }

    private function setPictureSize(Picture $picture): void
    {
        $localFile = $picture->getLocalFile();
        [$width, $height] = getimagesize($localFile->getRealPath());
        $picture
            ->setHeight($height)
            ->setWidth($width);
    }
}
