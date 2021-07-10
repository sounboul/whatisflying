<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Attributes\Updatable;
use App\Repository\AircraftTypePictureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['read']]
)]
#[UniqueEntity(['aircraftType', 'name'])]
#[ORM\Entity(repositoryClass: AircraftTypePictureRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'aircraft_type_picture')]
#[ORM\Table(name: 'aircraft_type_picture')]
class AircraftTypePicture extends Picture
{
    /**
     * @var AircraftType The aircraft type to which the picture belongs.
     */
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: AircraftType::class, inversedBy: 'pictures')]
    #[ORM\JoinColumn(name: 'aircraft_type', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected AircraftType $aircraftType;

    public function getAircraftType(): AircraftType
    {
        return $this->aircraftType;
    }

    public function setAircraftType(AircraftType $aircraftType): AircraftTypePicture
    {
        $this->aircraftType = $aircraftType;
        return $this;
    }
}
