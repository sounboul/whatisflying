<?php

declare(strict_types=1);

namespace App\Service\FileUploader;

use Ramsey\Uuid\UuidFactoryInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

final class FileUploader implements FileUploaderInterface
{
    public function __construct(
        private UuidFactoryInterface $uuidFactory,
        private string $uploadDirectory
    ) {
    }

    public function remove(string $filepath): void
    {
        $filesystem = new Filesystem();
        $filesystem->remove(sprintf('%s/%s', $this->uploadDirectory, $filepath));
    }

    public function upload(string $filepath): File
    {
        $file = new File($filepath);
        $uploadedFile = $file->move(
            $this->uploadDirectory,
            $this->uuidFactory->uuid4()->toString() . '.' . $file->guessExtension() ?? 'bin'
        );

        if (is_string($fileRealPath = $uploadedFile->getRealPath())) {
            $filesystem = new Filesystem();
            $filesystem->chown($fileRealPath, 'www-data');
            $filesystem->chmod($fileRealPath, 0644);
        }

        return $uploadedFile;
    }
}
