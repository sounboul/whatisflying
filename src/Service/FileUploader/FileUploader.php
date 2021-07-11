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

        $uploadedFilePath = sprintf(
            '%s/%s.%s',
            $this->uploadDirectory,
            $this->uuidFactory->uuid4()->toString(),
            $file->guessExtension() ?? 'bin'
        );

        $filesystem = new Filesystem();
        $filesystem->copy($filepath, $uploadedFilePath);

        $uploadedFile = new File($uploadedFilePath);

        if (is_string($uploadedFileRealPath = $uploadedFile->getRealPath())) {
            $filesystem->chown($uploadedFileRealPath, 'www-data');
            $filesystem->chmod($uploadedFileRealPath, 0644);
        }

        return $uploadedFile;
    }
}
