<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Attributes\Updatable;
use App\Repository\AirlineLogoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['read']]
)]
#[UniqueEntity(['airline'])]
#[ORM\Entity(repositoryClass: AirlineLogoRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'airline_logo')]
#[ORM\Table(name: 'airline_logo')]
class AirlineLogo extends FileEntity
{
    /**
     * @var Airline The airline to which the logo belongs.
     */
    #[Updatable]
    #[Assert\NotNull]
    #[ORM\OneToOne(inversedBy: 'logo', targetEntity: Airline::class)]
    #[ORM\JoinColumn(name: 'airline', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected Airline $airline;

    /**
     * @var File|null The local file that will be uploaded upon entity creation or update, or null if undefined.
     */
    #[Assert\File(maxSize: '512K', mimeTypes: ['image/svg', 'image/svg+xml'])]
    protected ?File $localFile = null;

    public function getAirline(): Airline
    {
        return $this->airline;
    }

    public function setAirline(Airline $airline): AirlineLogo
    {
        $this->airline = $airline;
        return $this;
    }
}
