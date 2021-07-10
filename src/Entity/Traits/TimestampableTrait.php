<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait TimestampableTrait
{
    /**
     * @var \DateTime The entity creation date and time.
     */
    #[ApiFilter(DateFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[ORM\Column(name: 'created', type: 'datetime_utc')]
    protected \DateTime $created;

    /**
     * @var \DateTime|null The entity modification date and time.
     */
    #[ApiFilter(DateFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[ORM\Column(name: 'updated', type: 'datetime_utc', nullable: true)]
    protected ?\DateTime $updated;

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function setCreated(\DateTime $created): self
    {
        $this->created = $created;
        return $this;
    }

    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTime $updated): self
    {
        $this->updated = $updated;
        return $this;
    }
}
