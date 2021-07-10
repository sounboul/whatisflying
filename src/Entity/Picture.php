<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Attributes\Updatable;
use App\Validator\Constraints as Constraints;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
abstract class Picture extends FileEntity
{
    /**
     * @var string The picture author's name.
     */
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[ORM\Column(name: 'author_name', type: 'string', length: 100)]
    protected string $authorName;

    /**
     * @var string|null The URL of the picture author's profile, or null if undefined.
     */
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Url]
    #[Assert\Length(max: 200)]
    #[ORM\Column(name: 'author_profile', type: 'string', length: 200, nullable: true)]
    protected ?string $authorProfile;

    /**
     * @var int The picture height, in pixels.
     */
    #[Groups(['read'])]
    #[ORM\Column(name: 'height', type: 'integer')]
    protected int $height;

    /**
     * @var string The picture license, as an SPDX license identifier.
     */
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    #[Constraints\License]
    #[ORM\Column(name: 'license', type: 'string', length: 50)]
    protected string $license;

    /**
     * @var string The picture source URL.
     */
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Url]
    #[Assert\Length(max: 200)]
    #[ORM\Column(name: 'source', type: 'string', length: 200)]
    protected string $source;

    /**
     * @var File|null The local file that will be uploaded upon entity creation or update, or null if undefined.
     */
    #[Updatable]
    #[Assert\Image(maxSize: '3M', mimeTypes: ['image/webp'], maxWidth: 3000, maxHeight: 2000)]
    protected ?File $localFile = null;

    /**
     * @var int The picture width, in pixels.
     */
    #[Groups(['read'])]
    #[ORM\Column(name: 'width', type: 'integer')]
    protected int $width;

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName): Picture
    {
        $this->authorName = $authorName;
        return $this;
    }

    public function getAuthorProfile(): ?string
    {
        return $this->authorProfile;
    }

    public function setAuthorProfile(?string $authorProfile): Picture
    {
        $this->authorProfile = $authorProfile;
        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): Picture
    {
        $this->height = $height;
        return $this;
    }

    public function getLicense(): string
    {
        return $this->license;
    }

    public function setLicense(string $license): Picture
    {
        $this->license = $license;
        return $this;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function setSource(string $source): Picture
    {
        $this->source = $source;
        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): Picture
    {
        $this->width = $width;
        return $this;
    }
}
