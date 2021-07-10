<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Entity\Attributes\Updatable;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UpdatableTrait;
use App\Repository\FixRepository;
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
    order: ['identifier' => 'ASC']
)]
#[ApiFilter(PropertyFilter::class)]
#[UniqueEntity(['slug'])]
#[ORM\Entity(repositoryClass: FixRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'fix')]
#[ORM\Table(name: 'fix')]
class Fix
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
     * @var Airport|null The airport to which the fix is associated, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class, properties: ['airport.icaoCode'])]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT, properties: ['airport.icaoCode'])]
    #[Groups(['read'])]
    #[Updatable]
    #[ORM\ManyToOne(targetEntity: Airport::class)]
    #[ORM\JoinColumn(name: 'airport', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    protected ?Airport $airport;

    /**
     * @var string The fix identifier.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 5)]
    #[ORM\Column(name: 'identifier', type: 'string', length: 5)]
    protected string $identifier;

    /**
     * @var float The fix latitude, in degrees.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Constraints\Latitude]
    #[ORM\Column(name: 'latitude', type: 'float', precision: 5)]
    protected float $latitude;

    /**
     * @var float The fix longitude, in degrees.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Constraints\Longitude]
    #[ORM\Column(name: 'longitude', type: 'float', precision: 5)]
    protected float $longitude;

    /**
     * @var string The ICAO region to which the fix belongs, as defined in the ICAO Document 7910.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Constraints\IcaoRegionCode]
    #[ORM\Column(name: 'region', type: 'string', length: 2)]
    protected string $region;

    /**
     * @var string The fix slug.
     */
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[ApiProperty(identifier: true)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Assert\Regex('/^[a-z0-9\-]+$/')]
    #[ORM\Column(name: 'slug', type: 'string', length: 120, unique: true)]
    protected string $slug;

    /**
     * @var string The fix usage type.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Assert\Choice(choices: ['ENROUTE', 'TERMINAL'])]
    #[ORM\Column(name: '__usage', type: 'string', length: 10)]
    protected string $usage;

    public function getAirport(): ?Airport
    {
        return $this->airport;
    }

    public function setAirport(?Airport $airport): Fix
    {
        $this->airport = $airport;
        return $this;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): Fix
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): Fix
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): Fix
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function setRegion(string $region): Fix
    {
        $this->region = $region;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): Fix
    {
        $this->slug = $slug;
        return $this;
    }

    public function getUsage(): string
    {
        return $this->usage;
    }

    public function setUsage(string $usage): Fix
    {
        $this->usage = $usage;
        return $this;
    }
}
