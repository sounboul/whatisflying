<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Entity\Attributes\Updatable;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UpdatableTrait;
use App\Repository\AircraftModelRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['read']],
    order: [
        'aircraftType.icaoCode' => 'ASC',
        'name' => 'ASC',
    ]
)]
#[ApiFilter(PropertyFilter::class)]
#[UniqueEntity(['aircraftType', 'engineManufacturer', 'name'])]
#[ORM\Entity(repositoryClass: AircraftModelRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'aircraft_model')]
#[ORM\Table(name: 'aircraft_model')]
class AircraftModel
{
    use IdentifiableTrait;
    use TimestampableTrait;
    use UpdatableTrait;

    /**
     * @var AircraftType The aircraft type to which the aircraft model belongs.
     */
    #[ApiFilter(OrderFilter::class, properties: ['aircraftType.icaoCode'])]
    #[ApiFilter(SearchFilter::class, strategy: 'exact', properties: ['aircraftType.icaoCode'])]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: AircraftType::class, inversedBy: 'aircraftModels')]
    #[ORM\JoinColumn(name: 'aircraft_type', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected AircraftType $aircraftType;

    /**
     * @var \DateTime|null The aircraft model certification date, or null if undefined.
     */
    #[ApiFilter(DateFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[ORM\Column(name: 'certified', type: 'date', nullable: true)]
    protected ?\DateTime $certified;

    /**
     * @var string The aircraft model engines manufacturer.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[ORM\Column(name: 'engine_manufacturer', type: 'string', length: 100)]
    protected string $engineManufacturer;

    /**
     * @var string The aircraft model engines model.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_PARTIAL)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 500)]
    #[ORM\Column(name: 'engine_model', type: 'string', length: 500)]
    protected string $engineModel;

    /**
     * @var string The aircraft model name.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_PARTIAL)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[ORM\Column(name: 'name', type: 'string', length: 100)]
    protected string $name;

    public function getAircraftType(): AircraftType
    {
        return $this->aircraftType;
    }

    public function setAircraftType(AircraftType $aircraftType): AircraftModel
    {
        $this->aircraftType = $aircraftType;
        return $this;
    }

    public function getCertified(): ?\DateTime
    {
        return $this->certified;
    }

    public function setCertified(?\DateTime $certified): AircraftModel
    {
        $this->certified = $certified;
        return $this;
    }

    public function getEngineManufacturer(): string
    {
        return $this->engineManufacturer;
    }

    public function setEngineManufacturer(string $engineManufacturer): AircraftModel
    {
        $this->engineManufacturer = $engineManufacturer;
        return $this;
    }

    public function getEngineModel(): string
    {
        return $this->engineModel;
    }

    public function setEngineModel(string $engineModel): AircraftModel
    {
        $this->engineModel = $engineModel;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): AircraftModel
    {
        $this->name = $name;
        return $this;
    }
}
