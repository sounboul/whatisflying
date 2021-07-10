<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

trait IdentifiableTrait
{
    /**
     * @todo         Remove the fully-qualified name if the issue is fixed.
     * @see          https://github.com/api-platform/core/issues/3344
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     *
     * @var \Ramsey\Uuid\UuidInterface The entity UUID.
     */
    #[ApiProperty(identifier: true)]
    #[Groups(['read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue('CUSTOM')]
    #[ORM\CustomIdGenerator(UuidGenerator::class)]
    #[ORM\Column(name: 'id', type: 'uuid', length: 36, unique: true)]
    protected UuidInterface $id;

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
