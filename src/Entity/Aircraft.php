<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Entity\Attributes\Updatable;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UpdatableTrait;
use App\Repository\AircraftRepository;
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
    order: ['registration' => 'ASC']
)]
#[ApiFilter(PropertyFilter::class)]
#[UniqueEntity(['icao24bitAddress'])]
#[ORM\Entity(repositoryClass: AircraftRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'aircraft')]
#[ORM\Table(name: 'aircraft')]
class Aircraft
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
     * @var string|null The aircraft family to which the aircraft belongs, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Regex('/^[AGHLT]$/')]
    #[ORM\Column(name: 'aircraft_family', type: 'string', length: 1, nullable: true)]
    protected ?string $aircraftFamily;

    /**
     * @var AircraftType|null The aircraft type to which the aircraft belongs, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class, properties: ['aircraftType.name'])]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT, properties: ['aircraftType.icaoCode', 'aircraftType.name'])]
    #[Groups(['read'])]
    #[Updatable]
    #[ORM\ManyToOne(targetEntity: AircraftType::class, inversedBy: 'aircraft')]
    #[ORM\JoinColumn(name: 'aircraft_type', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    protected ?AircraftType $aircraftType;

    /**
     * @var string|null The aircraft description, as defined in the ICAO Document 8643, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Constraints\IcaoAircraftDescription]
    #[ORM\Column(name: 'description', type: 'string', length: 4, nullable: true)]
    protected ?string $description;

    /**
     * @var int|null The aircraft engines count, or null if undefined.
     */
    #[ApiFilter(NumericFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'engine_count', type: 'integer', nullable: true)]
    protected ?int $engineCount;

    /**
     * @var string|null The aircraft engines type, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Regex('/^[EPJT]$/')]
    #[ORM\Column(name: 'engine_type', type: 'string', length: 1, nullable: true)]
    protected ?string $engineType;

    /**
     * @var string The aircraft ICAO 24-bit address.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[ApiProperty(identifier: true)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Constraints\Icao24bitAddress]
    #[ORM\Column(name: 'icao_24bit_address', type: 'string', length: 6, unique: true)]
    protected string $icao24bitAddress;

    /**
     * @var \DateTime|null The aircraft manufacturing date, or null if undefined.
     */
    #[ApiFilter(DateFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[ORM\Column(name: 'manufactured', type: 'date', nullable: true)]
    protected ?\DateTime $manufactured;

    /**
     * @var string The aircraft manufacturer.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_PARTIAL)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[ORM\Column(name: 'manufacturer', type: 'string', length: 100)]
    protected string $manufacturer;

    /**
     * @var string The aircraft model.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_PARTIAL)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[ORM\Column(name: 'model', type: 'string', length: 100)]
    protected string $model;

    /**
     * @var Airline|null The aircraft operator, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class, properties: ['operator.icaoCode'])]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT, properties: ['operator.icaoCode'])]
    #[Groups(['read'])]
    #[Updatable]
    #[ORM\ManyToOne(targetEntity: Airline::class, inversedBy: 'aircraft')]
    #[ORM\JoinColumn(name: 'operator', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    protected ?Airline $operator;

    /**
     * @var Collection<int, AircraftPicture> The aircraft pictures.
     */
    #[ApiSubresource]
    #[Groups(['read'])]
    #[ORM\OneToMany(mappedBy: 'aircraft', targetEntity: AircraftPicture::class, orphanRemoval: true)]
    protected Collection $pictures;

    /**
     * @var \DateTime|null The aircraft registration date, or null if undefined.
     */
    #[ApiFilter(DateFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[ORM\Column(name: 'registered', type: 'date', nullable: true)]
    protected ?\DateTime $registered;

    /**
     * @var \DateTime|null The aircraft registration expiration date, or null if undefined.
     */
    #[ApiFilter(DateFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[ORM\Column(name: 'registered_until', type: 'date', nullable: true)]
    protected ?\DateTime $registeredUntil;

    /**
     * @var string The aircraft registration.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 10)]
    #[ORM\Column(name: 'registration', type: 'string', length: 10)]
    protected string $registration;

    /**
     * @var string|null The aircraft registration country, as an ISO 3166-1 alpha-2 code, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Country]
    #[ORM\Column(name: 'registration_country', type: 'string', length: 2, nullable: true)]
    protected ?string $registrationCountry;

    /**
     * @var string The aircraft manufacturer serial number.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 20)]
    #[ORM\Column(name: 'serial_number', type: 'string', length: 20)]
    protected string $serialNumber;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
    }

    public function getAircraftFamily(): ?string
    {
        return $this->aircraftFamily;
    }

    public function setAircraftFamily(?string $aircraftFamily): Aircraft
    {
        $this->aircraftFamily = $aircraftFamily;
        return $this;
    }

    public function getAircraftType(): ?AircraftType
    {
        return $this->aircraftType;
    }

    public function setAircraftType(?AircraftType $aircraftType): Aircraft
    {
        $this->aircraftType = $aircraftType;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Aircraft
    {
        $this->description = $description;
        return $this;
    }

    public function getEngineCount(): ?int
    {
        return $this->engineCount;
    }

    public function setEngineCount(?int $engineCount): Aircraft
    {
        $this->engineCount = $engineCount;
        return $this;
    }

    public function getEngineType(): ?string
    {
        return $this->engineType;
    }

    public function setEngineType(?string $engineType): Aircraft
    {
        $this->engineType = $engineType;
        return $this;
    }

    public function getIcao24bitAddress(): string
    {
        return $this->icao24bitAddress;
    }

    public function setIcao24bitAddress(string $icao24bitAddress): Aircraft
    {
        $this->icao24bitAddress = $icao24bitAddress;
        return $this;
    }

    public function getManufactured(): ?\DateTime
    {
        return $this->manufactured;
    }

    public function setManufactured(?\DateTime $manufactured): Aircraft
    {
        $this->manufactured = $manufactured;
        return $this;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(string $manufacturer): Aircraft
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): Aircraft
    {
        $this->model = $model;
        return $this;
    }

    public function getOperator(): ?Airline
    {
        return $this->operator;
    }

    public function setOperator(?Airline $operator): Aircraft
    {
        $this->operator = $operator;
        return $this;
    }

    /**
     * Returns the first picture of the aircraft.
     *
     * @return AircraftPicture|null
     */
    #[Groups(['read'])]
    public function getFirstPicture(): ?AircraftPicture
    {
        if ($this->pictures->isEmpty()) {
            return null;
        }

        return $this->pictures->first();
    }

    /**
     * @return Collection<int, AircraftPicture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(AircraftPicture $picture): Aircraft
    {
        if (!$this->pictures->contains($picture)) {
            $picture->setAircraft($this);
            $this->pictures->add($picture);
        }

        return $this;
    }

    public function removePicture(AircraftPicture $picture): Aircraft
    {
        $this->pictures->removeElement($picture);
        return $this;
    }

    /**
     * @param Collection<int, AircraftPicture> $pictures
     *
     * @return Aircraft
     */
    public function setPictures(Collection $pictures): Aircraft
    {
        $this->pictures = $pictures;
        return $this;
    }

    public function getRegistered(): ?\DateTime
    {
        return $this->registered;
    }

    public function setRegistered(?\DateTime $registered): Aircraft
    {
        $this->registered = $registered;
        return $this;
    }

    public function getRegisteredUntil(): ?\DateTime
    {
        return $this->registeredUntil;
    }

    public function setRegisteredUntil(?\DateTime $registeredUntil): Aircraft
    {
        $this->registeredUntil = $registeredUntil;
        return $this;
    }

    public function getRegistration(): string
    {
        return $this->registration;
    }

    public function setRegistration(string $registration): Aircraft
    {
        $this->registration = $registration;
        return $this;
    }

    public function getRegistrationCountry(): ?string
    {
        return $this->registrationCountry;
    }

    public function setRegistrationCountry(?string $registrationCountry): Aircraft
    {
        $this->registrationCountry = $registrationCountry;
        return $this;
    }

    public function getSerialNumber(): string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(string $serialNumber): Aircraft
    {
        $this->serialNumber = $serialNumber;
        return $this;
    }
}
