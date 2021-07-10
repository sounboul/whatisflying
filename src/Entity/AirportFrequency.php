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
use App\Repository\AirportFrequencyRepository;
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
        'frequency' => 'ASC',
    ]
)]
#[ApiFilter(PropertyFilter::class)]
#[UniqueEntity(['airport', 'frequency', 'type'])]
#[ORM\Entity(repositoryClass: AirportFrequencyRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'airport_frequency')]
#[ORM\Table(name: 'airport_frequency')]
class AirportFrequency
{
    use IdentifiableTrait;
    use TimestampableTrait;
    use UpdatableTrait;

    /**
     * @var Airport The airport to which the radio frequency belongs.
     */
    #[ApiFilter(OrderFilter::class, properties: ['airport.icaoCode'])]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT, properties: ['airport.icaoCode'])]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Airport::class, inversedBy: 'frequencies')]
    #[ORM\JoinColumn(name: 'airport', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected Airport $airport;

    /**
     * @var string The radio frequency description.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_PARTIAL)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[ORM\Column(name: 'description', type: 'string', length: 100)]
    protected string $description;

    /**
     * @var int The radio frequency, in kilohertz.
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
     * @var string The radio frequency type.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_PARTIAL)]
    #[Groups(['read'])]
    #[Updatable]
    #[Assert\NotBlank]
    #[Assert\Length(max: 20)]
    #[ORM\Column(name: 'type', type: 'string', length: 20)]
    protected string $type;

    public function getAirport(): Airport
    {
        return $this->airport;
    }

    public function setAirport(Airport $airport): AirportFrequency
    {
        $this->airport = $airport;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): AirportFrequency
    {
        $this->description = $description;
        return $this;
    }

    public function getFrequency(): int
    {
        return $this->frequency;
    }

    public function setFrequency(int $frequency): AirportFrequency
    {
        $this->frequency = $frequency;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): AirportFrequency
    {
        $this->type = $type;
        return $this;
    }
}
