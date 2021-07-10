<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Entity\Attributes\Updatable;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UpdatableTrait;
use App\Repository\FirRepository;
use App\Validator\Constraints as Constraints;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['read']],
    order: ['icaoCode' => 'ASC']
)]
#[ApiFilter(PropertyFilter::class)]
#[UniqueEntity(['icaoCode'])]
#[ORM\Entity(repositoryClass: FirRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'fir')]
#[ORM\Table(name: 'fir')]
class Fir
{
    use IdentifiableTrait;
    use TimestampableTrait;
    use UpdatableTrait;

    /**
     * @var UuidInterface The entity UUID.
     */
    #[ApiProperty(identifier: false)]
    #[Groups(['read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue('CUSTOM')]
    #[ORM\CustomIdGenerator(UuidGenerator::class)]
    #[ORM\Column(name: 'id', type: 'uuid', length: 36, unique: true)]
    protected UuidInterface $id;

    /**
     * @var string The flight information region ICAO code.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[ApiProperty(identifier: true)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Constraints\IcaoFirCode]
    #[ORM\Column(name: 'icao_code', type: 'string', length: 4, unique: true)]
    protected string $icaoCode;

    /**
     * @var string The flight information region name.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_PARTIAL)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[ORM\Column(name: 'name', type: 'string', length: 100)]
    protected string $name;

    public function getIcaoCode(): string
    {
        return $this->icaoCode;
    }

    public function setIcaoCode(string $icaoCode): Fir
    {
        $this->icaoCode = $icaoCode;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Fir
    {
        $this->name = $name;
        return $this;
    }
}
