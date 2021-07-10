<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Entity\Attributes\Updatable;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UpdatableTrait;
use App\Repository\AircraftTypeRepository;
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
    order: [
        'manufacturer' => 'ASC',
        'name' => 'ASC',
    ]
)]
#[ApiFilter(PropertyFilter::class)]
#[UniqueEntity(['icaoCode'])]
#[ORM\Entity(repositoryClass: AircraftTypeRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'aircraft_type')]
#[ORM\Table(name: 'aircraft_type')]
class AircraftType
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
     * @var int|null The aircraft type absolute ceiling, in feet, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'absolute_ceiling', type: 'integer', nullable: true)]
    protected ?int $absoluteCeiling;

    /**
     * @var Collection<int, Aircraft> The aircraft that belongs to the aircraft type.
     */
    #[ApiSubresource(maxDepth: 1)]
    #[ORM\OneToMany(mappedBy: 'aircraftType', targetEntity: Aircraft::class)]
    protected Collection $aircraft;

    /**
     * @var string|null The aircraft family to which the aircraft type belongs, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Regex('/^[AGHLT]$/')]
    #[ORM\Column(name: 'aircraft_family', type: 'string', length: 1, nullable: true)]
    protected ?string $aircraftFamily;

    /**
     * @var Collection<int, AircraftModel> The aircraft models that belongs to the aircraft type.
     */
    #[ApiSubresource(maxDepth: 1)]
    #[ORM\OneToMany(mappedBy: 'aircraftType', targetEntity: AircraftModel::class, orphanRemoval: true)]
    protected Collection $aircraftModels;

    /**
     * @var int|null The aircraft type approach speed (Vref), in knots, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'approach_speed', type: 'integer', nullable: true)]
    protected ?int $approachSpeed;

    /**
     * @var int|null The aircraft type all-up weight, in kilograms, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'auw', type: 'integer', nullable: true)]
    protected ?int $auw;

    /**
     * @var int|null The aircraft type climb rate, in feet per minute, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'climb_rate', type: 'integer', nullable: true)]
    protected ?int $climbRate;

    /**
     * @var int|null The aircraft type cruise speed, in knots, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'cruise_speed', type: 'integer', nullable: true)]
    protected ?int $cruiseSpeed;

    /**
     * @var string|null The aircraft type description, as defined in the ICAO Document 8643, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Constraints\IcaoAircraftDescription]
    #[ORM\Column(name: 'description', type: 'string', length: 4, nullable: true)]
    protected ?string $description;

    /**
     * @var int|null The aircraft type engines count, or null if undefined.
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
     * @var string|null The aircraft type engines type, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Regex('/^[EPJT]$/')]
    #[ORM\Column(name: 'engine_type', type: 'string', length: 1, nullable: true)]
    protected ?string $engineType;

    /**
     * @var int|null The aircraft type ferry range, in nautical miles, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'ferry_range', type: 'integer', nullable: true)]
    protected ?int $ferryRange;

    /**
     * @var int|null The aircraft type fuel capacity, in litres, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'fuel_capacity', type: 'integer', nullable: true)]
    protected ?int $fuelCapacity;

    /**
     * @var float|null The aircraft type fuselage height, in metres, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'fuselage_height', type: 'float', precision: 2, nullable: true)]
    protected ?float $fuselageHeight;

    /**
     * @var float|null The aircraft type fuselage width, in metres, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'fuselage_width', type: 'float', precision: 2, nullable: true)]
    protected ?float $fuselageWidth;

    /**
     * @var float|null The aircraft type overall height, in metres, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'height', type: 'float', precision: 2, nullable: true)]
    protected ?float $height;

    /**
     * @var string|null The aircraft type IATA code, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Constraints\IataAircraftTypeCode]
    #[ORM\Column(name: 'iata_code', type: 'string', length: 3, nullable: true)]
    protected ?string $iataCode;

    /**
     * @var string The aircraft type ICAO code.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[ApiProperty(identifier: true)]
    #[Groups(['read'])]
    #[Updatable]
    #[Constraints\IcaoAircraftTypeCode]
    #[ORM\Column(name: 'icao_code', type: 'string', length: 4, unique: true)]
    protected string $icaoCode;

    /**
     * @var float|null The aircraft type overall length, in metres, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'length', type: 'float', precision: 2, nullable: true)]
    protected ?float $length;

    /**
     * @var float|null The aircraft type main rotor area, in square metres, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'main_rotor_area', type: 'float', precision: 2, nullable: true)]
    protected ?float $mainRotorArea;

    /**
     * @var float|null The aircraft type main rotor diameter, in metres, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'main_rotor_diameter', type: 'float', precision: 2, nullable: true)]
    protected ?float $mainRotorDiameter;

    /**
     * @var string The aircraft type manufacturer.
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
     * @var int|null The aircraft type maximum speed (Vmo), in knots, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'maximum_speed', type: 'integer', nullable: true)]
    protected ?int $maximumSpeed;

    /**
     * @var int|null The aircraft type maximum landing weight, in kilograms, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'mlw', type: 'integer', nullable: true)]
    protected ?int $mlw;

    /**
     * @var int|null The aircraft type maximum ramp weight, in kilograms, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'mrw', type: 'integer', nullable: true)]
    protected ?int $mrw;

    /**
     * @var int|null The aircraft type maximum takeoff weight, in kilograms, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'mtow', type: 'integer', nullable: true)]
    protected ?int $mtow;

    /**
     * @var int|null The aircraft type maximum zero-fuel weight, in kilograms, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'mzfw', type: 'integer', nullable: true)]
    protected ?int $mzfw;

    /**
     * @var string The aircraft type name.
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
     * @var int|null The aircraft type never exceed speed (Vne), in knots, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'never_exceed_speed', type: 'integer', nullable: true)]
    protected ?int $neverExceedSpeed;

    /**
     * @var int|null The aircraft type operating empty weight, in kilograms, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'oew', type: 'integer', nullable: true)]
    protected ?int $oew;

    /**
     * @var int|null The aircraft type operating range, in nautical miles, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'operating_range', type: 'integer', nullable: true)]
    protected ?int $operatingRange;

    /**
     * @var Collection<int, AircraftTypePicture> The aircraft type pictures.
     */
    #[ApiSubresource(maxDepth: 1)]
    #[Groups(['read'])]
    #[ORM\OneToMany(mappedBy: 'aircraftType', targetEntity: AircraftTypePicture::class, orphanRemoval: true)]
    protected Collection $pictures;

    /**
     * @var int|null The aircraft type service ceiling, in feet, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'service_ceiling', type: 'integer', nullable: true)]
    protected ?int $serviceCeiling;

    /**
     * @var string|null The aircraft type certificate URL, or null if undefined.
     */
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Url]
    #[Assert\Length(max: 200)]
    #[ORM\Column(name: 'type_certificate', type: 'string', length: 200, nullable: true)]
    protected ?string $typeCertificate;

    /**
     * @var float|null The aircraft type wing area, in square metres, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'wing_area', type: 'float', precision: 2, nullable: true)]
    protected ?float $wingArea;

    /**
     * @var float|null The aircraft type wingspan, in metres, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'wingspan', type: 'float', precision: 2, nullable: true)]
    protected ?float $wingspan;

    /**
     * @var string|null The aircraft type ICAO wake turbulence category, or null in undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Regex('/^[HLM]$/')]
    #[ORM\Column(name: 'wtc', type: 'string', length: 1, nullable: true)]
    protected ?string $wtc;

    public function __construct()
    {
        $this->aircraft = new ArrayCollection();
        $this->aircraftModels = new ArrayCollection();
        $this->pictures = new ArrayCollection();
    }

    public function getAbsoluteCeiling(): ?int
    {
        return $this->absoluteCeiling;
    }

    public function setAbsoluteCeiling(?int $absoluteCeiling): AircraftType
    {
        $this->absoluteCeiling = $absoluteCeiling;
        return $this;
    }

    /**
     * @return Collection<int, Aircraft>
     */
    public function getAircraft(): Collection
    {
        return $this->aircraft;
    }

    public function addAircraft(Aircraft $aircraft): AircraftType
    {
        if (!$this->aircraft->contains($aircraft)) {
            $aircraft->setAircraftType($this);
            $this->aircraft->add($aircraft);
        }

        return $this;
    }

    public function removeAircraft(Aircraft $aircraft): AircraftType
    {
        $this->aircraft->removeElement($aircraft);
        return $this;
    }

    /**
     * @param Collection<int, Aircraft> $aircraft
     *
     * @return AircraftType
     */
    public function setAircraft(Collection $aircraft): AircraftType
    {
        $this->aircraft = $aircraft;
        return $this;
    }

    public function getAircraftFamily(): ?string
    {
        return $this->aircraftFamily;
    }

    public function setAircraftFamily(?string $aircraftFamily): AircraftType
    {
        $this->aircraftFamily = $aircraftFamily;
        return $this;
    }

    /**
     * @return Collection<int, AircraftModel>
     */
    public function getAircraftModels(): Collection
    {
        return $this->aircraftModels;
    }

    public function addAircraftModel(AircraftModel $aircraftModel): AircraftType
    {
        if (!$this->aircraftModels->contains($aircraftModel)) {
            $aircraftModel->setAircraftType($this);
            $this->aircraftModels->add($aircraftModel);
        }

        return $this;
    }

    public function removeAircraftModel(AircraftModel $aircraftModel): AircraftType
    {
        $this->aircraftModels->removeElement($aircraftModel);
        return $this;
    }

    /**
     * @param Collection<int, AircraftModel> $aircraftModels
     *
     * @return AircraftType
     */
    public function setAircraftModels(Collection $aircraftModels): AircraftType
    {
        $this->aircraftModels = $aircraftModels;
        return $this;
    }

    public function getApproachSpeed(): ?int
    {
        return $this->approachSpeed;
    }

    public function setApproachSpeed(?int $approachSpeed): AircraftType
    {
        $this->approachSpeed = $approachSpeed;
        return $this;
    }

    public function getAuw(): ?int
    {
        return $this->auw;
    }

    public function setAuw(?int $auw): AircraftType
    {
        $this->auw = $auw;
        return $this;
    }

    public function getClimbRate(): ?int
    {
        return $this->climbRate;
    }

    public function setClimbRate(?int $climbRate): AircraftType
    {
        $this->climbRate = $climbRate;
        return $this;
    }

    public function getCruiseSpeed(): ?int
    {
        return $this->cruiseSpeed;
    }

    public function setCruiseSpeed(?int $cruiseSpeed): AircraftType
    {
        $this->cruiseSpeed = $cruiseSpeed;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): AircraftType
    {
        $this->description = $description;
        return $this;
    }

    public function getEngineCount(): ?int
    {
        return $this->engineCount;
    }

    public function setEngineCount(?int $engineCount): AircraftType
    {
        $this->engineCount = $engineCount;
        return $this;
    }

    public function getEngineType(): ?string
    {
        return $this->engineType;
    }

    public function setEngineType(?string $engineType): AircraftType
    {
        $this->engineType = $engineType;
        return $this;
    }

    public function getFerryRange(): ?int
    {
        return $this->ferryRange;
    }

    public function setFerryRange(?int $ferryRange): AircraftType
    {
        $this->ferryRange = $ferryRange;
        return $this;
    }

    public function getFuelCapacity(): ?int
    {
        return $this->fuelCapacity;
    }

    public function setFuelCapacity(?int $fuelCapacity): AircraftType
    {
        $this->fuelCapacity = $fuelCapacity;
        return $this;
    }

    public function getFuselageHeight(): ?float
    {
        return $this->fuselageHeight;
    }

    public function setFuselageHeight(?float $fuselageHeight): AircraftType
    {
        $this->fuselageHeight = $fuselageHeight;
        return $this;
    }

    public function getFuselageWidth(): ?float
    {
        return $this->fuselageWidth;
    }

    public function setFuselageWidth(?float $fuselageWidth): AircraftType
    {
        $this->fuselageWidth = $fuselageWidth;
        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(?float $height): AircraftType
    {
        $this->height = $height;
        return $this;
    }

    public function getIataCode(): ?string
    {
        return $this->iataCode;
    }

    public function setIataCode(?string $iataCode): AircraftType
    {
        $this->iataCode = $iataCode;
        return $this;
    }

    public function getIcaoCode(): string
    {
        return $this->icaoCode;
    }

    public function setIcaoCode(string $icaoCode): AircraftType
    {
        $this->icaoCode = $icaoCode;
        return $this;
    }

    public function getLength(): ?float
    {
        return $this->length;
    }

    public function setLength(?float $length): AircraftType
    {
        $this->length = $length;
        return $this;
    }

    public function getMainRotorArea(): ?float
    {
        return $this->mainRotorArea;
    }

    public function setMainRotorArea(?float $mainRotorArea): AircraftType
    {
        $this->mainRotorArea = $mainRotorArea;
        return $this;
    }

    public function getMainRotorDiameter(): ?float
    {
        return $this->mainRotorDiameter;
    }

    public function setMainRotorDiameter(?float $mainRotorDiameter): AircraftType
    {
        $this->mainRotorDiameter = $mainRotorDiameter;
        return $this;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(string $manufacturer): AircraftType
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    public function getMaximumSpeed(): ?int
    {
        return $this->maximumSpeed;
    }

    public function setMaximumSpeed(?int $maximumSpeed): AircraftType
    {
        $this->maximumSpeed = $maximumSpeed;
        return $this;
    }

    public function getMlw(): ?int
    {
        return $this->mlw;
    }

    public function setMlw(?int $mlw): AircraftType
    {
        $this->mlw = $mlw;
        return $this;
    }

    public function getMrw(): ?int
    {
        return $this->mrw;
    }

    public function setMrw(?int $mrw): AircraftType
    {
        $this->mrw = $mrw;
        return $this;
    }

    public function getMtow(): ?int
    {
        return $this->mtow;
    }

    public function setMtow(?int $mtow): AircraftType
    {
        $this->mtow = $mtow;
        return $this;
    }

    public function getMzfw(): ?int
    {
        return $this->mzfw;
    }

    public function setMzfw(?int $mzfw): AircraftType
    {
        $this->mzfw = $mzfw;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): AircraftType
    {
        $this->name = $name;
        return $this;
    }

    public function getNeverExceedSpeed(): ?int
    {
        return $this->neverExceedSpeed;
    }

    public function setNeverExceedSpeed(?int $neverExceedSpeed): AircraftType
    {
        $this->neverExceedSpeed = $neverExceedSpeed;
        return $this;
    }

    public function getOew(): ?int
    {
        return $this->oew;
    }

    public function setOew(?int $oew): AircraftType
    {
        $this->oew = $oew;
        return $this;
    }

    public function getOperatingRange(): ?int
    {
        return $this->operatingRange;
    }

    public function setOperatingRange(?int $operatingRange): AircraftType
    {
        $this->operatingRange = $operatingRange;
        return $this;
    }

    /**
     * Returns the aircraft type first picture.
     *
     * @return AircraftTypePicture|null
     */
    #[Groups(['read'])]
    public function getFirstPicture(): ?AircraftTypePicture
    {
        if ($this->pictures->isEmpty()) {
            return null;
        }

        return $this->pictures->first();
    }

    /**
     * @return Collection<int, AircraftTypePicture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(AircraftTypePicture $picture): AircraftType
    {
        if (!$this->pictures->contains($picture)) {
            $picture->setAircraftType($this);
            $this->pictures->add($picture);
        }

        return $this;
    }

    public function removePicture(AircraftTypePicture $picture): AircraftType
    {
        $this->pictures->removeElement($picture);
        return $this;
    }

    /**
     * @param Collection<int, AircraftTypePicture> $pictures
     *
     * @return AircraftType
     */
    public function setPictures(Collection $pictures): AircraftType
    {
        $this->pictures = $pictures;
        return $this;
    }

    public function getServiceCeiling(): ?int
    {
        return $this->serviceCeiling;
    }

    public function setServiceCeiling(?int $serviceCeiling): AircraftType
    {
        $this->serviceCeiling = $serviceCeiling;
        return $this;
    }

    public function getTypeCertificate(): ?string
    {
        return $this->typeCertificate;
    }

    public function setTypeCertificate(?string $typeCertificate): AircraftType
    {
        $this->typeCertificate = $typeCertificate;
        return $this;
    }

    public function getWingArea(): ?float
    {
        return $this->wingArea;
    }

    public function setWingArea(?float $wingArea): AircraftType
    {
        $this->wingArea = $wingArea;
        return $this;
    }

    public function getWingspan(): ?float
    {
        return $this->wingspan;
    }

    public function setWingspan(?float $wingspan): AircraftType
    {
        $this->wingspan = $wingspan;
        return $this;
    }

    public function getWtc(): ?string
    {
        return $this->wtc;
    }

    public function setWtc(?string $wtc): AircraftType
    {
        $this->wtc = $wtc;
        return $this;
    }
}
