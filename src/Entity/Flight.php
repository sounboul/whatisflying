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
use App\Repository\FlightRepository;
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
    order: ['flightNumber' => 'ASC']
)]
#[ApiFilter(PropertyFilter::class)]
#[UniqueEntity(['flightNumber'])]
#[ORM\Entity(repositoryClass: FlightRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'flight')]
#[ORM\Table(name: 'flight')]
class Flight
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
     * @var Airline The airline for which the flight is operated.
     */
    #[ApiFilter(OrderFilter::class, properties: ['airline.name'])]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT, properties: ['airline.icaoCode'])]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Airline::class, inversedBy: 'flights')]
    #[ORM\JoinColumn(name: 'airline', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected Airline $airline;

    /**
     * @var Airport The flight arrival airport.
     */
    #[ApiFilter(OrderFilter::class, properties: ['arrivalAirport.country', 'arrivalAirport.name'])]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT, properties: ['arrivalAirport.icaoCode'])]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Airport::class)]
    #[ORM\JoinColumn(name: 'arrival_airport', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected Airport $arrivalAirport;

    /**
     * @var Airport The flight departure airport.
     */
    #[ApiFilter(OrderFilter::class, properties: ['departureAirport.country', 'departureAirport.name'])]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT, properties: ['departureAirport.icaoCode'])]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Airport::class)]
    #[ORM\JoinColumn(name: 'departure_airport', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected Airport $departureAirport;

    /**
     * @var string The flight number.
     */
    #[ApiProperty(identifier: true)]
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 8)]
    #[ORM\Column(name: 'flight_number', type: 'string', length: 8, unique: true)]
    protected string $flightNumber;

    /**
     * @var Collection<int, Airport> The flight layover airports.
     */
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\Count(max: 10)]
    #[ORM\ManyToMany(targetEntity: Airport::class)]
    #[ORM\JoinTable(name: 'flight_layover_airport')]
    #[ORM\JoinColumn(name: 'flight', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'airport', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected Collection $layoverAirports;

    public function __construct()
    {
        $this->layoverAirports = new ArrayCollection();
    }

    public function getAirline(): Airline
    {
        return $this->airline;
    }

    public function setAirline(Airline $airline): Flight
    {
        $this->airline = $airline;
        return $this;
    }

    public function getArrivalAirport(): Airport
    {
        return $this->arrivalAirport;
    }

    public function setArrivalAirport(Airport $arrivalAirport): Flight
    {
        $this->arrivalAirport = $arrivalAirport;
        return $this;
    }

    public function getDepartureAirport(): Airport
    {
        return $this->departureAirport;
    }

    public function setDepartureAirport(Airport $departureAirport): Flight
    {
        $this->departureAirport = $departureAirport;
        return $this;
    }

    public function getFlightNumber(): string
    {
        return $this->flightNumber;
    }

    public function setFlightNumber(string $flightNumber): Flight
    {
        $this->flightNumber = $flightNumber;
        return $this;
    }

    /**
     * @return Collection<int, Airport>
     */
    public function getLayoverAirports(): Collection
    {
        return $this->layoverAirports;
    }

    public function addLayoverAirport(Airport $airport): Flight
    {
        if (!$this->layoverAirports->contains($airport)) {
            $this->layoverAirports->add($airport);
        }

        return $this;
    }

    public function removeLayoverAirport(Airport $airport): Flight
    {
        $this->layoverAirports->removeElement($airport);
        return $this;
    }

    /**
     * @param Collection<int, Airport> $layoverAirports
     *
     * @return Flight
     */
    public function setLayoverAirports(Collection $layoverAirports): Flight
    {
        $this->layoverAirports = $layoverAirports;
        return $this;
    }
}
