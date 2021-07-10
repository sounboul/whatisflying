<?php

declare(strict_types=1);

namespace App\Doctrine\ORM\EventSubscriber;

use App\Entity\FileEntity;
use App\Service\FileUploader\FileUploaderInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

final class FileEventSubscriber implements EventSubscriber
{
    public function __construct(private FileUploaderInterface $fileUploader)
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postRemove,
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $file = $args->getObject();

        if (!$file instanceof FileEntity) {
            return;
        }

        $this->removeFile($file);
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $file = $args->getObject();

        if (!$file instanceof FileEntity) {
            return;
        }

        $this->uploadFile($file);
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $file = $args->getObject();

        if (!$file instanceof FileEntity) {
            return;
        }

        if (!is_null($file->getLocalFile())) {
            $this->removeFile($file);
            $this->uploadFile($file);
        }
    }

    private function removeFile(FileEntity $file): void
    {
        $this->fileUploader->remove($file->getPath());
    }

    private function uploadFile(FileEntity $file): void
    {
        $localFile = $file->getLocalFile();
        $uploadedFile = $this->fileUploader->upload($localFile->getRealPath());
        $file
            ->setChecksum(sha1_file($uploadedFile->getRealPath()))
            ->setName($localFile->getFilename())
            ->setPath($uploadedFile->getFilename())
            ->setSize($uploadedFile->getSize())
            ->setType($uploadedFile->getType());
    }
}
