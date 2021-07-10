<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
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
use App\Repository\NavaidRepository;
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
    order: ['slug' => 'ASC']
)]
#[ApiFilter(PropertyFilter::class)]
#[UniqueEntity(['slug'])]
#[ORM\Entity(repositoryClass: NavaidRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'navaid')]
#[ORM\Table(name: 'navaid')]
class Navaid
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
     * @var Airport|null The airport to which the navaid is associated, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class, properties: ['airport.icaoCode'])]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT, properties: ['airport.icaoCode'])]
    #[Groups(['read'])]
    #[Updatable]
    #[ORM\ManyToOne(targetEntity: Airport::class)]
    #[ORM\JoinColumn(name: 'airport', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    protected ?Airport $airport;

    /**
     * @var string|null The airport runway to which the navaid is associated, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Length(max: 5)]
    #[ORM\Column(name: 'airport_runway', type: 'string', length: 5, nullable: true)]
    protected ?string $airportRunway;

    /**
     * @var string The country where the navaid is located, as an ISO 3166-1 alpha-2 code.
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
     * @var float|null The bias of the navaid DME part, in nautical miles, or null if undefined.
     */
    #[ApiFilter(NumericFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\PositiveOrZero]
    #[ORM\Column(name: 'dme_bias', type: 'float', precision: 2, nullable: true)]
    protected ?float $dmeBias;

    /**
     * @var string|null The channel of the navaid DME part, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Length(max: 4)]
    #[ORM\Column(name: 'dme_channel', type: 'string', length: 4, nullable: true)]
    protected ?string $dmeChannel;

    /**
     * @var int|null The RX frequency of the navaid DME part, in kilohertz, or null if undefined.
     */
    #[ApiFilter(NumericFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'dme_rx_frequency', type: 'integer', nullable: true)]
    protected ?int $dmeRXFrequency;

    /**
     * @var int|null The TX frequency of the navaid DME part, in kilohertz, or null if undefined.
     */
    #[ApiFilter(NumericFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'dme_tx_frequency', type: 'integer', nullable: true)]
    protected ?int $dmeTXFrequency;

    /**
     * @var int|null The navaid elevation, in feet above mean sea level, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[ORM\Column(name: 'elevation', type: 'integer', nullable: true)]
    protected ?int $elevation;

    /**
     * @var int The navaid frequency, in kilohertz.
     */
    #[ApiFilter(NumericFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Assert\Positive]
    #[ORM\Column(name: 'frequency', type: 'integer')]
    protected int $frequency;

    /**
     * @var float|null The angle of the navaid glide slope part, in degrees, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'glide_slope_angle', type: 'float', precision: 2, nullable: true)]
    protected ?float $glideSlopeAngle;

    /**
     * @var string The navaid identifier.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 4)]
    #[ORM\Column(name: 'identifier', type: 'string', length: 4)]
    protected string $identifier;

    /**
     * @var float The navaid latitude, in degrees.
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
     * @var float|null The magnetic heading of the navaid localizer part, in degrees, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Constraints\MagneticHeading]
    #[ORM\Column(name: 'localizer_heading', type: 'float', precision: 3, nullable: true)]
    protected ?float $localizerHeading;

    /**
     * @var float The navaid longitude, in degrees.
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
     * @var string The navaid name.
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
     * @var int|null The navaid reception range, in nautical miles, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'reception_range', type: 'integer', nullable: true)]
    protected ?int $receptionRange;

    /**
     * @var string The ICAO region to which the navaid belongs, as defined in the ICAO Document 7910.
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
     * @var string The navaid slug.
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
     * @var string The navaid type.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Constraints\NavaidType]
    #[ORM\Column(name: 'type', type: 'string', length: 10)]
    protected string $type;

    /**
     * @var string The navaid usage type.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Assert\Choice(choices: ['ENROUTE', 'TERMINAL'])]
    #[ORM\Column(name: '__usage', type: 'string', length: 10)]
    protected string $usage;

    /**
     * @var float|null The slaved variation of the navaid VOR part, in degrees, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Constraints\MagneticVariation]
    #[ORM\Column(name: 'vor_slaved_variation', type: 'float', precision: 3, nullable: true)]
    protected ?float $vorSlavedVariation;

    public function getAirport(): ?Airport
    {
        return $this->airport;
    }

    public function setAirport(?Airport $airport): Navaid
    {
        $this->airport = $airport;
        return $this;
    }

    public function getAirportRunway(): ?string
    {
        return $this->airportRunway;
    }

    public function setAirportRunway(?string $airportRunway): Navaid
    {
        $this->airportRunway = $airportRunway;
        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): Navaid
    {
        $this->country = $country;
        return $this;
    }

    public function getDmeBias(): ?float
    {
        return $this->dmeBias;
    }

    public function setDmeBias(?float $dmeBias): Navaid
    {
        $this->dmeBias = $dmeBias;
        return $this;
    }

    public function getDmeChannel(): ?string
    {
        return $this->dmeChannel;
    }

    public function setDmeChannel(?string $dmeChannel): Navaid
    {
        $this->dmeChannel = $dmeChannel;
        return $this;
    }

    public function getDmeRXFrequency(): ?int
    {
        return $this->dmeRXFrequency;
    }

    public function setDmeRXFrequency(?int $dmeRXFrequency): Navaid
    {
        $this->dmeRXFrequency = $dmeRXFrequency;
        return $this;
    }

    public function getDmeTXFrequency(): ?int
    {
        return $this->dmeTXFrequency;
    }

    public function setDmeTXFrequency(?int $dmeTXFrequency): Navaid
    {
        $this->dmeTXFrequency = $dmeTXFrequency;
        return $this;
    }

    public function getElevation(): ?int
    {
        return $this->elevation;
    }

    public function setElevation(?int $elevation): Navaid
    {
        $this->elevation = $elevation;
        return $this;
    }

    public function getFrequency(): int
    {
        return $this->frequency;
    }

    public function setFrequency(int $frequency): Navaid
    {
        $this->frequency = $frequency;
        return $this;
    }

    public function getGlideSlopeAngle(): ?float
    {
        return $this->glideSlopeAngle;
    }

    public function setGlideSlopeAngle(?float $glideSlopeAngle): Navaid
    {
        $this->glideSlopeAngle = $glideSlopeAngle;
        return $this;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): Navaid
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): Navaid
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLocalizerHeading(): ?float
    {
        return $this->localizerHeading;
    }

    public function setLocalizerHeading(?float $localizerHeading): Navaid
    {
        $this->localizerHeading = $localizerHeading;
        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): Navaid
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Navaid
    {
        $this->name = $name;
        return $this;
    }

    public function getReceptionRange(): ?int
    {
        return $this->receptionRange;
    }

    public function setReceptionRange(?int $receptionRange): Navaid
    {
        $this->receptionRange = $receptionRange;
        return $this;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function setRegion(string $region): Navaid
    {
        $this->region = $region;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): Navaid
    {
        $this->slug = $slug;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Navaid
    {
        $this->type = $type;
        return $this;
    }

    public function getUsage(): string
    {
        return $this->usage;
    }

    public function setUsage(string $usage): Navaid
    {
        $this->usage = $usage;
        return $this;
    }

    public function getVorSlavedVariation(): ?float
    {
        return $this->vorSlavedVariation;
    }

    public function setVorSlavedVariation(?float $vorSlavedVariation): Navaid
    {
        $this->vorSlavedVariation = $vorSlavedVariation;
        return $this;
    }
}
