<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Attributes\Updatable;
use App\Repository\AirlinePictureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['read']]
)]
#[UniqueEntity(['airline', 'name'])]
#[ORM\Entity(repositoryClass: AirlinePictureRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'airline_picture')]
#[ORM\Table(name: 'airline_picture')]
class AirlinePicture extends Picture
{
    /**
     * @var Airline The airline to which the picture belongs.
     */
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Airline::class, inversedBy: 'pictures')]
    #[ORM\JoinColumn(name: 'airline', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected Airline $airline;

    public function getAirline(): Airline
    {
        return $this->airline;
    }

    public function setAirline(Airline $airline): AirlinePicture
    {
        $this->airline = $airline;
        return $this;
    }
}
