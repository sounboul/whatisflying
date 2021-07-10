<?php

declare(strict_types=1);

namespace App\Service\FileUploader;

use Symfony\Component\HttpFoundation\File\File;

interface FileUploaderInterface
{
    /**
     * Removes a file from the upload directory.
     *
     * @param string $filepath The file to remove.
     */
    public function remove(string $filepath): void;

    /**
     * Uploads a file.
     *
     * @param string $filepath The file to upload.
     *
     * @return File The uploaded file.
     */
    public function upload(string $filepath): File;
}
