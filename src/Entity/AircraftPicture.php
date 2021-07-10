<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Attributes\Updatable;
use App\Repository\AircraftPictureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['read']]
)]
#[UniqueEntity(['aircraft', 'name'])]
#[ORM\Entity(repositoryClass: AircraftPictureRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'aircraft_picture')]
#[ORM\Table(name: 'aircraft_picture')]
class AircraftPicture extends Picture
{
    /**
     * @var Aircraft The aircraft to which the picture belongs.
     */
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Aircraft::class, inversedBy: 'pictures')]
    #[ORM\JoinColumn(name: 'aircraft', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected Aircraft $aircraft;

    public function getAircraft(): Aircraft
    {
        return $this->aircraft;
    }

    public function setAircraft(Aircraft $aircraft): AircraftPicture
    {
        $this->aircraft = $aircraft;
        return $this;
    }
}
