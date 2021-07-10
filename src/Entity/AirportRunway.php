<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
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
use App\Repository\AirportRunwayRepository;
use App\Validator\Constraints as Constraints;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['read']],
    order: [
        'airport.icaoCode' => 'ASC',
        'heName' => 'ASC',
        'leName' => 'ASC',
    ]
)]
#[ApiFilter(PropertyFilter::class)]
#[UniqueEntity(['airport', 'heName', 'leName'])]
#[ORM\Entity(repositoryClass: AirportRunwayRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'airport_runway')]
#[ORM\Table(name: 'airport_runway')]
class AirportRunway
{
    use IdentifiableTrait;
    use TimestampableTrait;
    use UpdatableTrait;

    /**
     * @var bool Whether the runway is active.
     */
    #[ApiFilter(BooleanFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\Column(name: 'active', type: 'boolean')]
    protected bool $active;

    /**
     * @var Airport The airport to which the runway belongs.
     */
    #[ApiFilter(OrderFilter::class, properties: ['airport.icaoCode'])]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT, properties: ['airport.icaoCode'])]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Airport::class, inversedBy: 'runways')]
    #[ORM\JoinColumn(name: 'airport', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected Airport $airport;

    /**
     * @var int|null The runway higher end displaced threshold length, in feet, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'he_displaced_threshold', type: 'integer', nullable: true)]
    protected ?int $heDisplacedThreshold;

    /**
     * @var int|null The runway higher end elevation, in feet above mean sea level, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[ORM\Column(name: 'he_elevation', type: 'integer', nullable: true)]
    protected ?int $heElevation;

    /**
     * @var float|null The runway higher end magnetic heading, in degrees, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Constraints\MagneticHeading]
    #[ORM\Column(name: 'he_heading', type: 'float', precision: 1, nullable: true)]
    protected ?float $heHeading;

    /**
     * @var float The runway higher end latitude, in degrees.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Constraints\Latitude]
    #[ORM\Column(name: 'he_latitude', type: 'float', precision: 5)]
    protected float $heLatitude;

    /**
     * @var float The runway higher end longitude, in degrees.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Constraints\Longitude]
    #[ORM\Column(name: 'he_longitude', type: 'float', precision: 5)]
    protected float $heLongitude;

    /**
     * @var string The runway higher end name.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 3)]
    #[ORM\Column(name: 'he_name', type: 'string', length: 3)]
    protected string $heName;

    /**
     * @var int The runway length, in feet.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'length', type: 'integer')]
    protected int $length;

    /**
     * @var bool Whether the runway is lighted.
     */
    #[ApiFilter(BooleanFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\Column(name: 'lighted', type: 'boolean')]
    protected bool $lighted;

    /**
     * @var int|null The runway lower end displaced threshold length, in feet, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Positive]
    #[ORM\Column(name: 'le_displaced_threshold', type: 'integer', nullable: true)]
    protected ?int $leDisplacedThreshold;

    /**
     * @var int|null The runway lower end elevation, in feet above mean sea level, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[ORM\Column(name: 'le_elevation', type: 'integer', nullable: true)]
    protected ?int $leElevation;

    /**
     * @var float|null The runway lower end magnetic heading, in degrees, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Constraints\MagneticHeading]
    #[ORM\Column(name: 'le_heading', type: 'float', precision: 1, nullable: true)]
    protected ?float $leHeading;

    /**
     * @var float The runway lower end latitude, in degrees.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Constraints\Latitude]
    #[ORM\Column(name: 'le_latitude', type: 'float', precision: 5)]
    protected float $leLatitude;

    /**
     * @var float The runway lower end longitude, in degrees.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Constraints\Longitude]
    #[ORM\Column(name: 'le_longitude', type: 'float', precision: 5)]
    protected float $leLongitude;

    /**
     * @var string The runway lower end name.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 3)]
    #[ORM\Column(name: 'le_name', type: 'string', length: 3)]
    protected string $leName;

    /**
     * @var string|null The runway surface, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Regex('/^(ASP|BIT|BRI|CLA|COM|CON|COP|COR|GRE|GRS|GVL|ICE|LAT|MAC|PEM|PER|PSP|SAN|SMT|SNO|WAT)$/')]
    #[ORM\Column(name: 'surface', type: 'string', length: 3, nullable: true)]
    protected ?string $surface;

    /**
     * @var int The runway width, in feet.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Assert\Positive]
    #[ORM\Column(name: 'width', type: 'integer')]
    protected int $width;

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): AirportRunway
    {
        $this->active = $active;
        return $this;
    }

    public function getAirport(): Airport
    {
        return $this->airport;
    }

    public function setAirport(Airport $airport): AirportRunway
    {
        $this->airport = $airport;
        return $this;
    }

    public function getHEDisplacedThreshold(): ?int
    {
        return $this->heDisplacedThreshold;
    }

    public function setHEDisplacedThreshold(?int $heDisplacedThreshold): AirportRunway
    {
        $this->heDisplacedThreshold = $heDisplacedThreshold;
        return $this;
    }

    public function getHEElevation(): ?int
    {
        return $this->heElevation;
    }

    public function setHEElevation(?int $heElevation): AirportRunway
    {
        $this->heElevation = $heElevation;
        return $this;
    }

    public function getHEHeading(): ?float
    {
        return $this->heHeading;
    }

    public function setHEHeading(?float $heHeading): AirportRunway
    {
        $this->heHeading = $heHeading;
        return $this;
    }

    public function getHELatitude(): float
    {
        return $this->heLatitude;
    }

    public function setHELatitude(float $heLatitude): AirportRunway
    {
        $this->heLatitude = $heLatitude;
        return $this;
    }

    public function getHELongitude(): float
    {
        return $this->heLongitude;
    }

    public function setHELongitude(float $heLongitude): AirportRunway
    {
        $this->heLongitude = $heLongitude;
        return $this;
    }

    public function getHEName(): string
    {
        return $this->heName;
    }

    public function setHEName(string $heName): AirportRunway
    {
        $this->heName = $heName;
        return $this;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): AirportRunway
    {
        $this->length = $length;
        return $this;
    }

    public function isLighted(): bool
    {
        return $this->lighted;
    }

    public function setLighted(bool $lighted): AirportRunway
    {
        $this->lighted = $lighted;
        return $this;
    }

    public function getLEDisplacedThreshold(): ?int
    {
        return $this->leDisplacedThreshold;
    }

    public function setLEDisplacedThreshold(?int $leDisplacedThreshold): AirportRunway
    {
        $this->leDisplacedThreshold = $leDisplacedThreshold;
        return $this;
    }

    public function getLEElevation(): ?int
    {
        return $this->leElevation;
    }

    public function setLEElevation(?int $leElevation): AirportRunway
    {
        $this->leElevation = $leElevation;
        return $this;
    }

    public function getLEHeading(): ?float
    {
        return $this->leHeading;
    }

    public function setLEHeading(?float $leHeading): AirportRunway
    {
        $this->leHeading = $leHeading;
        return $this;
    }

    public function getLELatitude(): float
    {
        return $this->leLatitude;
    }

    public function setLELatitude(float $leLatitude): AirportRunway
    {
        $this->leLatitude = $leLatitude;
        return $this;
    }

    public function getLELongitude(): float
    {
        return $this->leLongitude;
    }

    public function setLELongitude(float $leLongitude): AirportRunway
    {
        $this->leLongitude = $leLongitude;
        return $this;
    }

    public function getLEName(): string
    {
        return $this->leName;
    }

    public function setLEName(string $leName): AirportRunway
    {
        $this->leName = $leName;
        return $this;
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(?string $surface): AirportRunway
    {
        $this->surface = $surface;
        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): AirportRunway
    {
        $this->width = $width;
        return $this;
    }
}
