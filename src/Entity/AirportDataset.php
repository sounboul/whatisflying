<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
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
use App\Repository\AirportDatasetRepository;
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
        'year' => 'DESC',
    ]
)]
#[ApiFilter(PropertyFilter::class)]
#[UniqueEntity(['airport', 'year'])]
#[ORM\Entity(repositoryClass: AirportDatasetRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'airport_dataset')]
#[ORM\Table(name: 'airport_dataset')]
class AirportDataset
{
    use IdentifiableTrait;
    use TimestampableTrait;
    use UpdatableTrait;

    /**
     * @var Airport The airport to which the dataset applies.
     */
    #[ApiFilter(OrderFilter::class, properties: ['airport.icaoCode'])]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT, properties: ['airport.icaoCode'])]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Airport::class, inversedBy: 'datasets')]
    #[ORM\JoinColumn(name: 'airport', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected Airport $airport;

    /**
     * @var int The number of domestic flights that departed from the airport.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[ORM\Column(name: 'domestic_departures', type: 'integer')]
    protected int $domesticDepartures;

    /**
     * @var int The number of domestic destinations serviced by the airport.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[ORM\Column(name: 'domestic_destinations', type: 'integer')]
    protected int $domesticDestinations;

    /**
     * @var int The number of international flights that departed from the airport.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[ORM\Column(name: 'international_departures', type: 'integer')]
    protected int $internationalDepartures;

    /**
     * @var int The number of international destinations serviced by the airport.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[ORM\Column(name: 'international_destinations', type: 'integer')]
    protected int $internationalDestinations;

    /**
     * @var int The dataset year.
     */
    #[ApiFilter(NumericFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[Assert\Positive]
    #[ORM\Column(name: 'year', type: 'integer')]
    protected int $year;

    public function getAirport(): Airport
    {
        return $this->airport;
    }

    public function setAirport(Airport $airport): AirportDataset
    {
        $this->airport = $airport;
        return $this;
    }

    public function getDomesticDepartures(): int
    {
        return $this->domesticDepartures;
    }

    public function setDomesticDepartures(int $domesticDepartures): AirportDataset
    {
        $this->domesticDepartures = $domesticDepartures;
        return $this;
    }

    public function getDomesticDestinations(): int
    {
        return $this->domesticDestinations;
    }

    public function setDomesticDestinations(int $domesticDestinations): AirportDataset
    {
        $this->domesticDestinations = $domesticDestinations;
        return $this;
    }

    public function getInternationalDepartures(): int
    {
        return $this->internationalDepartures;
    }

    public function setInternationalDepartures(int $internationalDepartures): AirportDataset
    {
        $this->internationalDepartures = $internationalDepartures;
        return $this;
    }

    public function getInternationalDestinations(): int
    {
        return $this->internationalDestinations;
    }

    public function setInternationalDestinations(int $internationalDestinations): AirportDataset
    {
        $this->internationalDestinations = $internationalDestinations;
        return $this;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): AirportDataset
    {
        $this->year = $year;
        return $this;
    }
}
