<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UpdatableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\MappedSuperclass]
abstract class FileEntity
{
    use IdentifiableTrait;
    use TimestampableTrait;
    use UpdatableTrait;

    /**
     * @var string|null The file SHA1 checksum, or null if undefined.
     */
    #[ORM\Column(name: 'checksum', type: 'string', length: 40)]
    protected ?string $checksum;

    /**
     * @var File|null The local file that will be uploaded upon entity creation or update, or null if undefined.
     */
    protected ?File $localFile;

    /**
     * @var string The file name.
     */
    #[ORM\Column(name: 'name', type: 'string', length: 200)]
    protected string $name;

    /**
     * @var string The file path.
     */
    #[Groups(['read'])]
    #[ORM\Column(name: 'path', type: 'string', length: 200, unique: true)]
    protected string $path;

    /**
     * @var int The file size, in bytes.
     */
    #[Groups(['read'])]
    #[ORM\Column(name: 'size', type: 'bigint')]
    protected int $size;

    /**
     * @var string The file MIME type.
     */
    #[Groups(['read'])]
    #[ORM\Column(name: 'type', type: 'string', length: 50)]
    protected string $type;

    /**
     * @var string The file absolute URL.
     */
    #[Groups(['read'])]
    protected string $url;

    public function __construct()
    {
        $this->checksum = null;
    }

    public function getChecksum(): ?string
    {
        return $this->checksum;
    }

    public function setChecksum(string $checksum): FileEntity
    {
        $this->checksum = $checksum;
        return $this;
    }

    public function getLocalFile(): ?File
    {
        return $this->localFile;
    }

    public function setLocalFile(?File $localFile): FileEntity
    {
        $this->localFile = $localFile;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): FileEntity
    {
        $this->name = $name;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): FileEntity
    {
        $this->path = $path;
        return $this;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): FileEntity
    {
        $this->size = $size;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): FileEntity
    {
        $this->type = $type;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): FileEntity
    {
        $this->url = $url;
        return $this;
    }
}
