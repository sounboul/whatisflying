<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Entity\Attributes\Updatable;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UpdatableTrait;
use App\Repository\AirportRepository;
use App\Validator\Constraints as Constraints;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
#[UniqueEntity(['iataCode'])]
#[UniqueEntity(['icaoCode'])]
#[ORM\Entity(repositoryClass: AirportRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'airport')]
#[ORM\Table(name: 'airport')]
class Airport
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
     * @var bool Whether the airport is active.
     */
    #[ApiFilter(BooleanFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[ORM\Column(name: 'active', type: 'boolean')]
    protected bool $active;

    /**
     * @var string The continent where the airport is located, as a 2 letter continent code.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Constraints\Continent]
    #[ORM\Column(name: 'continent', type: 'string', length: 2)]
    protected string $continent;

    /**
     * @var string The country where the airport is located, as an ISO 3166-1 alpha-2 code.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Assert\Country]
    #[ORM\Column(name: 'country', type: 'string', length: 2)]
    protected string $country;

    /**
     * @var Collection<int, AirportDataset> The datasets that applies to the airport.
     */
    #[ApiSubresource(maxDepth: 1)]
    #[ORM\OneToMany(mappedBy: 'airport', targetEntity: AirportDataset::class, orphanRemoval: true)]
    protected Collection $datasets;

    /**
     * @var int|null The airport elevation, in feet above mean sea level, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[ORM\Column(name: 'elevation', type: 'integer', nullable: true)]
    protected ?int $elevation;

    /**
     * @var Fir|null The flight information region to which the airport belongs, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class, properties: ['fir.icaoCode'])]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT, properties: ['fir.icaoCode'])]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Fir::class)]
    #[ORM\JoinColumn(name: 'fir', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    protected ?Fir $fir;

    /**
     * @var Collection<int, AirportFrequency> The radio frequencies that belongs to the airport.
     */
    #[ApiSubresource(maxDepth: 1)]
    #[ORM\OneToMany(mappedBy: 'airport', targetEntity: AirportFrequency::class, orphanRemoval: true)]
    protected Collection $frequencies;

    /**
     * @var string|null The airport IATA code, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Constraints\IataAirportCode]
    #[ORM\Column(name: 'iata_code', type: 'string', length: 3, unique: true, nullable: true)]
    protected ?string $iataCode;

    /**
     * @var string The airport ICAO code.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[ApiProperty(identifier: true)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Constraints\IcaoAirportCode]
    #[ORM\Column(name: 'icao_code', type: 'string', length: 4, unique: true)]
    protected string $icaoCode;

    /**
     * @var bool Whether the airport is international.
     */
    #[ApiFilter(BooleanFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[ORM\Column(name: 'international', type: 'boolean')]
    protected bool $international;

    /**
     * @var float The airport latitude, in degrees.
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
     * @var float The airport longitude, in degrees.
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
     * @var string The airport name.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_PARTIAL)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[ORM\Column(name: 'name', type: 'string', length: 100)]
    protected string $name;

    /**
     * @var Collection<int, AirportRunway> The runways that belongs to the airport.
     */
    #[ApiSubresource(maxDepth: 1)]
    #[ORM\OneToMany(mappedBy: 'airport', targetEntity: AirportRunway::class, orphanRemoval: true)]
    protected Collection $runways;

    /**
     * @var string The airport type.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Assert\Choice(choices: ['small', 'medium', 'large'])]
    #[ORM\Column(name: 'type', type: 'string', length: 10)]
    protected string $type;

    public function __construct()
    {
        $this->datasets = new ArrayCollection();
        $this->frequencies = new ArrayCollection();
        $this->runways = new ArrayCollection();
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): Airport
    {
        $this->active = $active;
        return $this;
    }

    public function getContinent(): string
    {
        return $this->continent;
    }

    public function setContinent(string $continent): Airport
    {
        $this->continent = $continent;
        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): Airport
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return Collection<int, AirportDataset>
     */
    public function getDatasets(): Collection
    {
        return $this->datasets;
    }

    public function addDataset(AirportDataset $dataset): Airport
    {
        if (!$this->datasets->contains($dataset)) {
            $dataset->setAirport($this);
            $this->datasets->add($dataset);
        }

        return $this;
    }

    public function removeDataset(AirportDataset $dataset): Airport
    {
        $this->datasets->removeElement($dataset);
        return $this;
    }

    /**
     * @param Collection<int, AirportDataset> $datasets
     *
     * @return Airport
     */
    public function setDatasets(Collection $datasets): Airport
    {
        $this->datasets = $datasets;
        return $this;
    }

    public function getElevation(): ?int
    {
        return $this->elevation;
    }

    public function setElevation(?int $elevation): Airport
    {
        $this->elevation = $elevation;
        return $this;
    }

    public function getFir(): ?Fir
    {
        return $this->fir;
    }

    public function setFir(?Fir $fir): Airport
    {
        $this->fir = $fir;
        return $this;
    }

    /**
     * @return Collection<int, AirportFrequency>
     */
    public function getFrequencies(): Collection
    {
        return $this->frequencies;
    }

    public function addFrequency(AirportFrequency $frequency): Airport
    {
        if (!$this->frequencies->contains($frequency)) {
            $frequency->setAirport($this);
            $this->frequencies->add($frequency);
        }

        return $this;
    }

    public function removeFrequency(AirportFrequency $frequency): Airport
    {
        $this->frequencies->removeElement($frequency);
        return $this;
    }

    /**
     * @param Collection<int, AirportFrequency> $frequencies
     *
     * @return Airport
     */
    public function setFrequencies(Collection $frequencies): Airport
    {
        $this->frequencies = $frequencies;
        return $this;
    }

    public function getIataCode(): ?string
    {
        return $this->iataCode;
    }

    public function setIataCode(?string $iataCode): Airport
    {
        $this->iataCode = $iataCode;
        return $this;
    }

    public function getIcaoCode(): string
    {
        return $this->icaoCode;
    }

    public function setIcaoCode(string $icaoCode): Airport
    {
        $this->icaoCode = $icaoCode;
        return $this;
    }

    public function isInternational(): bool
    {
        return $this->international;
    }

    public function setInternational(bool $international): Airport
    {
        $this->international = $international;
        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): Airport
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): Airport
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Airport
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection<int, AirportRunway>
     */
    public function getRunways(): Collection
    {
        return $this->runways;
    }

    public function addRunway(AirportRunway $runway): Airport
    {
        if (!$this->runways->contains($runway)) {
            $runway->setAirport($this);
            $this->runways->add($runway);
        }

        return $this;
    }

    public function removeRunway(AirportRunway $runway): Airport
    {
        $this->runways->removeElement($runway);
        return $this;
    }

    /**
     * @param Collection<int, AirportRunway> $runways
     *
     * @return Airport
     */
    public function setRunways(Collection $runways): Airport
    {
        $this->runways = $runways;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Airport
    {
        $this->type = $type;
        return $this;
    }
}
