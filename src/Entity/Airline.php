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
use App\Repository\AirlineRepository;
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
#[UniqueEntity(['icaoCode'])]
#[ORM\Entity(repositoryClass: AirlineRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'airline')]
#[ORM\Table(name: 'airline')]
class Airline
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
     * @var int|null The number of accidents involving the airline during the last 5 years, or null if undefined.
     */
    #[ApiFilter(RangeFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\PositiveOrZero]
    #[ORM\Column(name: 'accidents_last_5_years', type: 'integer', nullable: true)]
    protected ?int $accidentsLast5Years;

    /**
     * @var bool Whether the airline is active.
     */
    #[ApiFilter(BooleanFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\Column(name: 'active', type: 'boolean')]
    protected bool $active;

    /**
     * @var Collection<int, Aircraft> The airline fleet.
     */
    #[ApiSubresource(maxDepth: 1)]
    #[ORM\OneToMany(mappedBy: 'operator', targetEntity: Aircraft::class)]
    protected Collection $aircraft;

    /**
     * @var int|null The number of aircraft over 25 years old within the airline fleet, or null if undefined.
     */
    #[ApiFilter(RangeFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\PositiveOrZero]
    #[ORM\Column(name: 'aircraft_over_25_years', type: 'integer', nullable: true)]
    protected ?int $aircraftOver25Years;

    /**
     * @var int|null The number of domestic flights operated annually by the airline, or null if undefined.
     */
    #[ApiFilter(RangeFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\PositiveOrZero]
    #[ORM\Column(name: 'annual_domestic_flights', type: 'integer', nullable: true)]
    protected ?int $annualDomesticFlights;

    /**
     * @var int|null The number of international flights operated annually by the airline, or null if undefined.
     */
    #[ApiFilter(RangeFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\PositiveOrZero]
    #[ORM\Column(name: 'annual_international_flights', type: 'integer', nullable: true)]
    protected ?int $annualInternationalFlights;

    /**
     * @var float|null The airline average fleet age, or null if undefined.
     */
    #[ApiFilter(RangeFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\PositiveOrZero]
    #[ORM\Column(name: 'average_fleet_age', type: 'float', precision: 2, nullable: true)]
    protected ?float $averageFleetAge;

    /**
     * @var string|null The airline callsign, or null if undefined.
     */
    #[ApiFilter(RangeFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_PARTIAL)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Length(max: 100)]
    #[ORM\Column(name: 'callsign', type: 'string', length: 100, nullable: true)]
    protected ?string $callsign;

    /**
     * @var string The airline registration country, as an ISO 3166-1 alpha-2 code.
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
     * @var int|null The number of destinations serviced by the airline, or null if undefined.
     */
    #[ApiFilter(RangeFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\PositiveOrZero]
    #[ORM\Column(name: 'destinations', type: 'integer', nullable: true)]
    protected ?int $destinations;

    /**
     * @var int|null The number of fatal accidents involving the airline during the last 5 years, or null if undefined.
     */
    #[ApiFilter(RangeFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\PositiveOrZero]
    #[ORM\Column(name: 'fatal_accidents_last_5_years', type: 'integer', nullable: true)]
    protected ?int $fatalAccidentsLast5Years;

    /**
     * @var Collection<int, Flight> The airline flights.
     */
    #[ApiSubresource(maxDepth: 1)]
    #[ORM\OneToMany(mappedBy: 'airline', targetEntity: Flight::class)]
    protected Collection $flights;

    /**
     * @var string|null The airline IATA code, or null if undefined.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Constraints\IataAirlineCode]
    #[ORM\Column(name: 'iata_code', type: 'string', length: 3, nullable: true)]
    protected ?string $iataCode;

    /**
     * @var bool Whether the airline is member of the IATA.
     */
    #[ApiFilter(BooleanFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\Column(name: 'iata_member', type: 'boolean')]
    protected bool $iataMember;

    /**
     * @var string The airline ICAO code.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[ApiProperty(identifier: true)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Constraints\IcaoAirlineCode]
    #[ORM\Column(name: 'icao_code', type: 'string', length: 3, unique: true)]
    protected string $icaoCode;

    /**
     * @var bool Whether the airline operates international flights.
     */
    #[ApiFilter(BooleanFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\Column(name: 'international', type: 'boolean')]
    protected bool $international;

    /**
     * @var bool Whether the airline is IOSA certified.
     */
    #[ApiFilter(BooleanFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\Column(name: 'iosa_certified', type: 'boolean')]
    protected bool $iosaCertified;

    /**
     * @var AirlineLogo|null The airline logo, or null if undefined.
     */
    #[Groups(['read'])]
    #[ORM\OneToOne(mappedBy: 'airline', targetEntity: AirlineLogo::class, orphanRemoval: true)]
    protected ?AirlineLogo $logo;

    /**
     * @var string The airline name.
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
     * @var Collection<int, AirlinePicture> The airline pictures.
     */
    #[ApiSubresource(maxDepth: 1)]
    #[Groups(['read'])]
    #[ORM\OneToMany(mappedBy: 'airline', targetEntity: AirlinePicture::class, orphanRemoval: true)]
    protected Collection $pictures;

    public function __construct()
    {
        $this->aircraft = new ArrayCollection();
        $this->flights = new ArrayCollection();
        $this->pictures = new ArrayCollection();
    }

    public function getAccidentsLast5Years(): ?int
    {
        return $this->accidentsLast5Years;
    }

    public function setAccidentsLast5Years(?int $accidentsLast5Years): Airline
    {
        $this->accidentsLast5Years = $accidentsLast5Years;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): Airline
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return Collection<int, Aircraft>
     */
    public function getAircraft(): Collection
    {
        return $this->aircraft;
    }

    public function addAircraft(Aircraft $aircraft): Airline
    {
        if (!$this->aircraft->contains($aircraft)) {
            $aircraft->setOperator($this);
            $this->aircraft->add($aircraft);
        }

        return $this;
    }

    public function removeAircraft(Aircraft $aircraft): Airline
    {
        $this->aircraft->removeElement($aircraft);
        return $this;
    }

    /**
     * @param Collection<int, Aircraft> $aircraft
     *
     * @return Airline
     */
    public function setAircraft(Collection $aircraft): Airline
    {
        $this->aircraft = $aircraft;
        return $this;
    }

    public function getAircraftOver25Years(): ?int
    {
        return $this->aircraftOver25Years;
    }

    public function setAircraftOver25Years(?int $aircraftOver25Years): Airline
    {
        $this->aircraftOver25Years = $aircraftOver25Years;
        return $this;
    }

    public function getAnnualDomesticFlights(): ?int
    {
        return $this->annualDomesticFlights;
    }

    public function setAnnualDomesticFlights(?int $annualDomesticFlights): Airline
    {
        $this->annualDomesticFlights = $annualDomesticFlights;
        return $this;
    }

    public function getAnnualInternationalFlights(): ?int
    {
        return $this->annualInternationalFlights;
    }

    public function setAnnualInternationalFlights(?int $annualInternationalFlights): Airline
    {
        $this->annualInternationalFlights = $annualInternationalFlights;
        return $this;
    }

    public function getAverageFleetAge(): ?float
    {
        return $this->averageFleetAge;
    }

    public function setAverageFleetAge(?float $averageFleetAge): Airline
    {
        $this->averageFleetAge = $averageFleetAge;
        return $this;
    }

    public function getCallsign(): ?string
    {
        return $this->callsign;
    }

    public function setCallsign(?string $callsign): Airline
    {
        $this->callsign = $callsign;
        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): Airline
    {
        $this->country = $country;
        return $this;
    }

    public function getDestinations(): ?int
    {
        return $this->destinations;
    }

    public function setDestinations(?int $destinations): Airline
    {
        $this->destinations = $destinations;
        return $this;
    }

    public function getFatalAccidentsLast5Years(): ?int
    {
        return $this->fatalAccidentsLast5Years;
    }

    public function setFatalAccidentsLast5Years(?int $fatalAccidentsLast5Years): Airline
    {
        $this->fatalAccidentsLast5Years = $fatalAccidentsLast5Years;
        return $this;
    }

    /**
     * @return Collection<int, Flight>
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

    public function addFlight(Flight $flight): Airline
    {
        if (!$this->flights->contains($flight)) {
            $flight->setAirline($this);
            $this->flights->add($flight);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): Airline
    {
        $this->flights->removeElement($flight);
        return $this;
    }

    /**
     * @param Collection<int, Flight> $flights
     *
     * @return Airline
     */
    public function setFlights(Collection $flights): Airline
    {
        $this->flights = $flights;
        return $this;
    }

    public function getIataCode(): ?string
    {
        return $this->iataCode;
    }

    public function setIataCode(?string $iataCode): Airline
    {
        $this->iataCode = $iataCode;
        return $this;
    }

    public function isIataMember(): bool
    {
        return $this->iataMember;
    }

    public function setIataMember(bool $iataMember): Airline
    {
        $this->iataMember = $iataMember;
        return $this;
    }

    public function getIcaoCode(): string
    {
        return $this->icaoCode;
    }

    public function setIcaoCode(string $icaoCode): Airline
    {
        $this->icaoCode = $icaoCode;
        return $this;
    }

    public function isInternational(): bool
    {
        return $this->international;
    }

    public function setInternational(bool $international): Airline
    {
        $this->international = $international;
        return $this;
    }

    public function isIosaCertified(): bool
    {
        return $this->iosaCertified;
    }

    public function setIosaCertified(bool $iosaCertified): Airline
    {
        $this->iosaCertified = $iosaCertified;
        return $this;
    }

    public function getLogo(): ?AirlineLogo
    {
        return $this->logo;
    }

    public function setLogo(?AirlineLogo $logo): Airline
    {
        $logo->setAirline($this);
        $this->logo = $logo;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Airline
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Returns the airline first picture.
     *
     * @return AirlinePicture|null
     */
    #[Groups(['read'])]
    public function getFirstPicture(): ?AirlinePicture
    {
        if ($this->pictures->isEmpty()) {
            return null;
        }

        return $this->pictures->first();
    }

    /**
     * @return Collection<int, AirlinePicture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(AirlinePicture $picture): Airline
    {
        if (!$this->pictures->contains($picture)) {
            $picture->setAirline($this);
            $this->pictures->add($picture);
        }

        return $this;
    }

    public function removePicture(AirlinePicture $picture): Airline
    {
        $this->pictures->removeElement($picture);
        return $this;
    }

    /**
     * @param Collection<int, AirlinePicture> $pictures
     *
     * @return Airline
     */
    public function setPictures(Collection $pictures): Airline
    {
        $this->pictures = $pictures;
        return $this;
    }
}
